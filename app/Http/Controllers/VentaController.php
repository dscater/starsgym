<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use PDF;
use App\library\numero_a_letras\src\NumeroALetras;
use App\Models\Configuracion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public $validacion = [
        "sucursal_id" => "required",
        "cliente_id" => "required",
        "total" => "required",
        "fecha" => "required|date",
    ];

    public function index()
    {
        $ventas = Venta::with("sucursal")->with("cliente")->get();
        if (Auth::user()->tipo != 'GERENTE') {
            $ventas = Venta::with("sucursal")->with("cliente")->where("sucursal_id", Auth::user()->sucursal_id)->get();
        }

        return response()->JSON(["ventas" => $ventas, "total" => count($ventas)]);
    }

    public function ventas_sucursal(Request $request)
    {
        $ventas = Venta::with("sucursal")->where("sucursal_id", $request->id)->get();
        return response()->JSON($ventas);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate($this->validacion);
            $request["fecha_registro"] = date("Y-m-d");
            $venta = Venta::create(array_map("mb_strtoupper", $request->except("detalle_ventas")));

            $detalle_ventas = $request->detalle_ventas;
            foreach ($detalle_ventas as $value) {
                $dv = $venta->detalle_ventas()->create([
                    "producto_id" => $value["producto_id"],
                    "cantidad" => $value["cantidad"],
                    "precio" => $value["precio"],
                    "subtotal" => $value["subtotal"],
                ]);
                $producto = Producto::find($dv->producto_id);
                $producto->stock_actual = (float) $producto->stock_actual - (float)$dv->cantidad;
                $producto->salidas = (float) $producto->salidas + (float)$dv->cantidad;
                $producto->save();
            }

            // QR
            $nro_factura = (int)$venta->id;
            if ($nro_factura < 10) {
                $nro_factura = '000' . $nro_factura;
            } else if ($nro_factura < 100) {
                $nro_factura = '00' . $nro_factura;
            } else if ($nro_factura < 1000) {
                $nro_factura = '0' . $nro_factura;
            }
            $codigo_qr = 'v' . $venta->id . time() . '.png'; //NOMBRE DE LA IMAGEN QR
            $configuracion = Configuracion::first();
            $qr = $configuracion->nit . '|' . $nro_factura . '|' . $venta->cliente->ci . '|' . $venta->cliente->paterno . '|' . $venta->total . '|' . $venta->fecha;
            $base_64 = base64_encode(\QrCode::format('png')->size(400)->generate($qr));
            $imagen_codigo_qr = base64_decode($base_64);
            file_put_contents(public_path() . '/imgs/qr/' . $codigo_qr, $imagen_codigo_qr);
            $venta->qr = $codigo_qr;
            $venta->save();
            // fin qr

            DB::commit();
            return response()->JSON(["sw" => true, "venta" => $venta, "id" => $venta->id, "msj" => "El registro se almacenó correctamente"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Venta $venta)
    {
        return response()->JSON($venta->load("detalle_ventas.producto"));
    }

    public function update(Venta $venta, Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate($this->validacion);
            $venta->update(array_map("mb_strtoupper", $request->except("detalle_ventas", "eliminados")));
            $detalle_ventas = $request->detalle_ventas;
            foreach ($detalle_ventas as $value) {
                if ($value["id"] == 0) {
                    $dv = $venta->detalle_ventas()->create([
                        "producto_id" => $value["producto_id"],
                        "cantidad" => $value["cantidad"],
                        "precio" => $value["precio"],
                        "subtotal" => $value["subtotal"],
                    ]);
                    $producto = Producto::find($dv->producto_id);
                    $producto->stock_actual = (float) $producto->stock_actual - (float)$dv->cantidad;
                    $producto->salidas = (float) $producto->salidas + (float)$dv->cantidad;
                    $producto->save();
                } else {
                    $dv = DetalleVenta::find($value["id"]);
                    if ((float)$dv->cantidad != (float)$value["cantidad"]) {
                        $dif = (float)$value["cantidad"] - (float)$dv->cantidad;
                        $producto = Producto::find($dv->producto_id);
                        $producto->stock_actual = (float) $producto->stock_actual - (float)$dif;
                        $producto->salidas = (float) $producto->salidas + (float)$dif;
                        $producto->save();
                        $dv->update([
                            "producto_id" => $value["producto_id"],
                            "cantidad" => $value["cantidad"],
                            "precio" => $value["precio"],
                            "subtotal" => $value["subtotal"],
                        ]);
                    }
                }
            }

            $eliminados = $request->eliminados;
            foreach ($eliminados as $value) {
                $dv = DetalleVenta::find($value);
                $producto = Producto::find($dv->producto_id);
                $producto->stock_actual = (float) $producto->stock_actual + (float)$dv->cantidad;
                $producto->salidas = (float) $producto->salidas - (float)$dv->cantidad;
                $producto->save();
                $dv->delete();
            }

            // ACTUALIZAR EL QR
            VentaController::eliminaQR(public_path() . '/imgs/qr/' . $venta->qr);
            // QR
            $nro_factura = (int)$venta->id;
            if ($nro_factura < 10) {
                $nro_factura = '000' . $nro_factura;
            } else if ($nro_factura < 100) {
                $nro_factura = '00' . $nro_factura;
            } else if ($nro_factura < 1000) {
                $nro_factura = '0' . $nro_factura;
            }
            $codigo_qr = 'v' . $venta->id . time() . '.png'; //NOMBRE DE LA IMAGEN QR
            $configuracion = Configuracion::first();
            $qr = $configuracion->nit . '|' . $nro_factura . '|' . $venta->cliente->ci . '|' . $venta->cliente->paterno . '|' . $venta->total . '|' . $venta->fecha;
            $base_64 = base64_encode(\QrCode::format('png')->size(400)->generate($qr));
            $imagen_codigo_qr = base64_decode($base_64);
            file_put_contents(public_path() . '/imgs/qr/' . $codigo_qr, $imagen_codigo_qr);
            $venta->qr = $codigo_qr;
            $venta->save();
            // fin qr

            DB::commit();
            return response()->JSON(["sw" => true, "venta" => $venta, "id" => $venta->id, "msj" => "El registro se actualizó correctamente"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Venta $venta)
    {
        DB::beginTransaction();
        try {
            VentaController::eliminaQR(public_path() . '/imgs/qr/' . $venta->qr);
            foreach ($venta->detalle_ventas as $dv) {
                $producto = Producto::find($dv->producto_id);
                $producto->stock_actual = (float) $producto->stock_actual + (float)$dv->cantidad;
                $producto->salidas = (float) $producto->salidas - (float)$dv->cantidad;
                $producto->save();
                $dv->delete();
            }
            $venta->delete();
            DB::commit();
            return response()->JSON(["sw" => true, "venta" => $venta, "msj" => "El registro se actualizó correctamente"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function pdf(Venta $venta)
    {
        $convertir = new NumeroALetras();
        $array_monto = explode('.', $venta->total);
        $literal = $convertir->convertir($array_monto[0]);
        $literal .= " " . $array_monto[1] . "/100." . " BOLIVIANOS";

        $nro_factura = (int)$venta->id;
        if ($nro_factura < 10) {
            $nro_factura = '000' . $nro_factura;
        } else if ($nro_factura < 100) {
            $nro_factura = '00' . $nro_factura;
        } else if ($nro_factura < 1000) {
            $nro_factura = '0' . $nro_factura;
        }

        if ($venta->qr == '' || $venta->qr == NULL) {
            // QR
            $codigo_qr = 'v' . $venta->id . time() . '.png'; //NOMBRE DE LA IMAGEN QR
            $configuracion = Configuracion::first();
            $qr = $configuracion->nit . '|' . $nro_factura . '|' . $venta->cliente->ci . '|' . $venta->cliente->paterno . '|' . $venta->total . '|' . $venta->fecha;
            $base_64 = base64_encode(\QrCode::format('png')->size(400)->generate($qr));
            $imagen_codigo_qr = base64_decode($base_64);
            file_put_contents(public_path() . '/imgs/qr/' . $codigo_qr, $imagen_codigo_qr);
            $venta->qr = $codigo_qr;
            $venta->save();
            // fin qr
        }

        $pdf = PDF::loadView('reportes.venta', compact('venta', 'literal', 'nro_factura'))->setPaper('legal', 'landscape');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->download('FacturaVenta.pdf');
    }

    public static function eliminaQR($ruta)
    {
        \File::delete($ruta);
        return true;
    }
}
