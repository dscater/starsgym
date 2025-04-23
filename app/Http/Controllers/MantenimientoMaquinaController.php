<?php

namespace App\Http\Controllers;

use App\Models\MantenimientoMaquina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MantenimientoMaquinaController extends Controller
{
    public $validacion = [
        "maquina_id" => "required",
        "sucursal_id" => "required",
    ];

    public $mensajes = [
        'sucursal_id.required' => 'Este campo es obligatorio',
    ];

    public function index(Request $request)
    {
        $mantenimiento_maquinas = MantenimientoMaquina::with("maquina.sucursal")->get();

        if (Auth::user()->tipo != 'GERENTE') {
            $mantenimiento_maquinas = MantenimientoMaquina::with("maquina.sucursal")->where("sucursal_id", Auth::user()->sucursal_id)->get();
        }

        return response()->JSON(['mantenimiento_maquinas' => $mantenimiento_maquinas, 'total' => count($mantenimiento_maquinas)], 200);
    }

    public function fechas_sugeridas()
    {
        $mantenimiento_maquinas = MantenimientoMaquina::with("maquina.sucursal")
            ->where("fecha_proximo", "!=", null)
            ->get();

        if (Auth::user()->tipo != 'GERENTE') {
            $mantenimiento_maquinas = MantenimientoMaquina::with("maquina.sucursal")->where("sucursal_id", Auth::user()->sucursal_id)
                ->where("fecha_proximo", "!=", null)
                ->get();
        }

        return response()->JSON(['mantenimiento_maquinas' => $mantenimiento_maquinas, 'total' => count($mantenimiento_maquinas)], 200);
    }

    public function store(Request $request)
    {
        if (isset($request->fecha_mantenimiento) && $request->fecha_mantenimiento != "") {
            $this->validacion['fecha_mantenimiento'] = 'date';
        }
        if (isset($request->fecha_proximo) && $request->fecha_proximo != "") {
            $this->validacion['fecha_proximo'] = 'date';
        }

        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        // CREAR EL USER
        $nuevo_mantenimiento_maquina = MantenimientoMaquina::create(array_map('mb_strtoupper', $request->except("fecha_mantenimiento", "fecha_proximo")));

        if (!$request->fecha_mantenimiento || $request->fecha_mantenimiento == "") {
            $nuevo_mantenimiento_maquina['fecha_mantenimiento'] = null;
        } else {
            $nuevo_mantenimiento_maquina['fecha_mantenimiento'] = $request->fecha_mantenimiento;
        }

        if (!$request->fecha_proximo || $request->fecha_proximo == "") {
            $nuevo_mantenimiento_maquina['fecha_proximo'] = null;
        } else {
            $nuevo_mantenimiento_maquina['fecha_proximo'] = $request->fecha_proximo;
        }

        $nuevo_mantenimiento_maquina->save();
        return response()->JSON([
            'sw' => true,
            'mantenimiento_maquina' => $nuevo_mantenimiento_maquina,
            'msj' => 'El registro se realizó de forma correcta',
        ], 200);
    }

    public function update(Request $request, MantenimientoMaquina $mantenimiento_maquina)
    {
        if (isset($request->fecha_mantenimiento) && $request->fecha_mantenimiento != "") {
            $this->validacion['fecha_mantenimiento'] = 'date';
        }
        if (isset($request->fecha_proximo) && $request->fecha_proximo != "") {
            $this->validacion['fecha_proximo'] = 'date';
        }

        $request->validate($this->validacion, $this->mensajes);
        $mantenimiento_maquina->update(array_map('mb_strtoupper', $request->except('fecha_mantenimiento', "fecha_proximo")));

        if (!$request->fecha_mantenimiento || $request->fecha_mantenimiento == "") {
            $mantenimiento_maquina->fecha_mantenimiento = null;
        } else {
            $mantenimiento_maquina->fecha_mantenimiento = $request->fecha_mantenimiento;
        }
        if (!$request->fecha_proximo || $request->fecha_proximo == "") {
            $mantenimiento_maquina->fecha_proximo = null;
        } else {
            $mantenimiento_maquina->fecha_proximo = $request->fecha_proximo;
        }

        $mantenimiento_maquina->save();
        return response()->JSON([
            'sw' => true,
            'mantenimiento_maquina' => $mantenimiento_maquina,
            'msj' => 'El registro se actualizó de forma correcta'
        ], 200);
    }

    public function show(MantenimientoMaquina $mantenimiento_maquina)
    {
        return response()->JSON([
            'sw' => true,
            'mantenimiento_maquina' => $mantenimiento_maquina
        ], 200);
    }

    public function destroy(MantenimientoMaquina $mantenimiento_maquina)
    {
        $antiguo = $mantenimiento_maquina->foto;
        if ($antiguo != 'default.png') {
            \File::delete(public_path() . '/imgs/mantenimiento_maquinas/' . $antiguo);
        }
        $mantenimiento_maquina->delete();
        return response()->JSON([
            'sw' => true,
            'msj' => 'El registro se eliminó correctamente'
        ], 200);
    }
}
