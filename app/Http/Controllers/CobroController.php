<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\library\numero_a_letras\src\NumeroALetras;
use App\Models\Configuracion;
use Illuminate\Support\Facades\DB;

class CobroController extends Controller
{
    public $validacion = [
        "cliente_id" => "required",
        "inscripcion_id" => "required",
        "sucursal_id" => "required",
        "fecha_cobro" => "required|date",
    ];

    public $messages = [
        "cliente_id.required" => "Debes seleccionar una cliente",
        "sucursal_id.required" => "Debes seleccionar una sucursal",
        "fecha_cobro.required" => "Debes indicar una fecha de cobro",
        "fecha_cobro.date" => "Debes indicar una fecha de cobro valido",
        "inscripcion_id.required" => "Debe existir una inscripción con un cobro Pendiente"
    ];

    public function index()
    {
        $cobros = Cobro::with("sucursal")
            ->with('inscripcion.plan')
            ->with("cliente")
            ->orderBy("created_at", "desc")
            ->get();
        if (Auth::user()->tipo != 'GERENTE') {
            $cobros = Cobro::with("sucursal")
                ->with('inscripcion.plan')
                ->with("cliente")
                ->where("sucursal_id", Auth::user()->sucursal_id)
                ->orderBy("created_at", "desc")
                ->get();
        }

        return response()->JSON(["cobros" => $cobros, "total" => count($cobros)]);
    }

    public function cobros_sucursal(Request $request)
    {
        $cobros = Cobro::with("sucursal")->where("sucursal_id", $request->id)->get();
        return response()->JSON($cobros);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate($this->validacion, $this->messages);
            $request["fecha_registro"] = date("Y-m-d");

            $inscripcion = Inscripcion::find($request->inscripcion_id);
            $cobro = Cobro::create(array_map("mb_strtoupper", $request->all()));
            $inscripcion->estado_cobro = "COMPLETO";
            $inscripcion->save();

            // QR
            $nro_factura = (int)$cobro->id;
            if ($nro_factura < 10) {
                $nro_factura = '000' . $nro_factura;
            } else if ($nro_factura < 100) {
                $nro_factura = '00' . $nro_factura;
            } else if ($nro_factura < 1000) {
                $nro_factura = '0' . $nro_factura;
            }
            $codigo_qr = 'v' . $cobro->id . time() . '.png'; //NOMBRE DE LA IMAGEN QR
            $configuracion = Configuracion::first();
            $qr = $configuracion->nit . '|' . $nro_factura . '|' . $cobro->inscripcion->cliente->ci . '|' . $cobro->inscripcion->cliente->paterno . '|' . $cobro->inscripcion->plan->costo . '|' . $cobro->fecha_cobro;
            $base_64 = base64_encode(\QrCode::format('png')->size(400)->generate($qr));
            $imagen_codigo_qr = base64_decode($base_64);
            file_put_contents(public_path() . '/imgs/qr/' . $codigo_qr, $imagen_codigo_qr);
            $cobro->qr = $codigo_qr;
            $cobro->save();
            // fin qr

            DB::commit();
            return response()->JSON(["sw" => true, "msj" => "El registro se almacenó correctamente"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Cobro $cobro)
    {
        return response()->JSON($cobro);
    }

    public function update(Cobro $cobro, Request $request)
    {
        $request->validate($this->validacion, $this->messages);
        $cobro->update(array_map("mb_strtoupper", $request->all()));
        return response()->JSON(["sw" => true, "cobro" => $cobro, "msj" => "El registro se actualizó correctamente"]);
    }

    public function destroy(Cobro $cobro)
    {
        DB::beginTransaction();
        try {
            $cobro->inscripcion->estado_cobro = "PENDIENTE";
            $cobro->inscripcion->save();
            $cobro->delete();
            DB::commit();
            return response()->JSON(["sw" => true, "cobro" => $cobro, "msj" => "El registro se actualizó correctamente"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function factura(Cobro $cobro)
    {
        $convertir = new NumeroALetras();
        $array_monto = explode('.', $cobro->inscripcion->plan->costo);
        $literal = $convertir->convertir($array_monto[0]);
        $literal .= " " . $array_monto[1] . "/100." . " BOLIVIANOS";

        $nro_factura = (int)$cobro->id;
        if ($nro_factura < 10) {
            $nro_factura = '000' . $nro_factura;
        } else if ($nro_factura < 100) {
            $nro_factura = '00' . $nro_factura;
        } else if ($nro_factura < 1000) {
            $nro_factura = '0' . $nro_factura;
        }

        if ($cobro->qr == '' || $cobro->qr == NULL) {
            // QR
            $codigo_qr = 'c' . $cobro->id . time() . '.png'; //NOMBRE DE LA IMAGEN QR
            $configuracion = Configuracion::first();
            $qr = $configuracion->nit . '|' . $nro_factura . '|' . $cobro->inscripcion->cliente->ci . '|' . $cobro->inscripcion->cliente->paterno . '|' . $cobro->inscripcion->plan->costo . '|' . $cobro->fecha_cobro;
            $base_64 = base64_encode(\QrCode::format('png')->size(400)->generate($qr));
            $imagen_codigo_qr = base64_decode($base_64);
            file_put_contents(public_path() . '/imgs/qr/' . $codigo_qr, $imagen_codigo_qr);
            $cobro->qr = $codigo_qr;
            $cobro->save();
            // fin qr
        }

        $pdf = PDF::loadView('reportes.factura', compact('cobro', 'literal', 'nro_factura'))->setPaper('legal', 'landscape');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->download('FacturaCobro.pdf');
    }
}
