<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    public $validacion = [
        "nombre" => "required",
        "ci" => "required|min:4|unique:empleados,ci",
        "ci_exp" => "required",
        "fecha_inicio" => "required|date",
        "sucursal_id" => "required",
    ];

    public $mensajes = [
        'sucursal_id.required' => 'Este campo es obligatorio',
    ];

    public function index(Request $request)
    {
        $empleados = Empleado::with("sucursal")->get();
        return response()->JSON(['empleados' => $empleados, 'total' => count($empleados)], 200);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpeg,jpg,png|max:2048';
        }

        if ($request->correo) {
            $this->validacion['correo'] = 'email';
        }

        if ($request->salario) {
            $this->validacion['salario'] = 'numeric';
        }

        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        // CREAR EL USER
        $nuevo_empleado = Empleado::create(array_map('mb_strtoupper', $request->except('foto')));

        $nuevo_empleado->foto = 'default.png';
        if ($request->hasFile('foto')) {
            $file = $request->foto;
            $nom_foto = time() . '_' . $nuevo_empleado->empleado . '.' . $file->getClientOriginalExtension();
            $nuevo_empleado->foto = $nom_foto;
            $file->move(public_path() . '/imgs/empleados/', $nom_foto);
        }

        $nuevo_empleado->save();
        return response()->JSON([
            'sw' => true,
            'empleado' => $nuevo_empleado,
            'msj' => 'El registro se realizó de forma correcta',
        ], 200);
    }

    public function update(Request $request, Empleado $empleado)
    {
        $this->validacion['ci'] = 'required|min:4|unique:empleados,ci,' . $empleado->id;
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpeg,jpg,png|max:2048';
        }

        if ($request->correo) {
            $this->validacion['correo'] = 'email';
        }

        if ($request->salario) {
            $this->validacion['salario'] = 'numeric';
        }

        $request->validate($this->validacion, $this->mensajes);
        $empleado->update(array_map('mb_strtoupper', $request->except('foto')));

        if (!$request->correo) {
            $empleado->correo = NULL;
        }

        if (!$request->salario) {
            $empleado->salario = NULL;
        }

        if ($request->hasFile('foto')) {
            $antiguo = $empleado->foto;
            if ($antiguo != 'default.png') {
                \File::delete(public_path() . '/imgs/empleados/' . $antiguo);
            }
            $file = $request->foto;
            $nom_foto = time() . '_' . $empleado->empleado . '.' . $file->getClientOriginalExtension();
            $empleado->foto = $nom_foto;
            $file->move(public_path() . '/imgs/empleados/', $nom_foto);
        }
        $empleado->save();
        return response()->JSON([
            'sw' => true,
            'empleado' => $empleado,
            'msj' => 'El registro se actualizó de forma correcta'
        ], 200);
    }

    public function show(Empleado $empleado)
    {
        return response()->JSON([
            'sw' => true,
            'empleado' => $empleado
        ], 200);
    }

    public function destroy(Empleado $empleado)
    {
        $antiguo = $empleado->foto;
        if ($antiguo != 'default.png') {
            \File::delete(public_path() . '/imgs/empleados/' . $antiguo);
        }
        $empleado->delete();
        return response()->JSON([
            'sw' => true,
            'msj' => 'El registro se eliminó correctamente'
        ], 200);
    }

    public function cargos()
    {
        $cargos = DB::select("SELECT cargo FROM empleados WHERE cargo!=''");
        
        return $cargos;
    }
}
