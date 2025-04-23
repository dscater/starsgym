<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaquinaController extends Controller
{
    public $validacion = [
        "nombre" => "required",
        "categoria_id" => "required",
        "sucursal_id" => "required",
        "estado" => "required",
    ];

    public $mensajes = [
        'sucursal_id.required' => 'Este campo es obligatorio',
    ];

    public function index(Request $request)
    {
        $maquinas = Maquina::with("sucursal")->with("categoria")->get();
        if (Auth::user()->tipo != 'GERENTE') {
            $maquinas = Maquina::with("sucursal")->with("categoria")->where("sucursal_id", Auth::user()->sucursal_id)->get();
        }
        return response()->JSON(['maquinas' => $maquinas, 'total' => count($maquinas)], 200);
    }

    public function maquinas_sucursal(Request $request)
    {
        $maquinas = Maquina::with("sucursal")->where("sucursal_id", $request->id)->get();
        return response()->JSON($maquinas);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpeg,jpg,png|max:2048';
        }

        if (isset($request->fecha_incorporacion) && $request->fecha_incorporacion != "") {
            $this->validacion['fecha_incorporacion'] = 'date';
        }
        if (isset($request->cantidad) && $request->cantidad != "") {
            $this->validacion['cantidad'] = 'numeric|min:1';
        }

        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        $request['codigo'] = "0";
        // CREAR EL USER
        $nueva_maquina = Maquina::create(array_map('mb_strtoupper', $request->except('foto', "fecha_incorporacion", "cantidad")));
        $nueva_maquina->codigo = $nueva_maquina->id;

        if (!$request->fecha_incorporacion || $request->fecha_incorporacion == "") {
            $nueva_maquina['fecha_incorporacion'] = null;
        } else {
            $nueva_maquina['fecha_incorporacion'] = $request->fecha_incorporacion;
        }
        if (!$request->cantidad || $request->cantidad == "") {
            $nueva_maquina['cantidad'] = null;
        } else {
            $nueva_maquina['cantidad'] = $request->cantidad;
        }

        $nueva_maquina->foto = 'default.png';
        if ($request->hasFile('foto')) {
            $file = $request->foto;
            $nom_foto = time() . '_' . $nueva_maquina->maquina . '.' . $file->getClientOriginalExtension();
            $nueva_maquina->foto = $nom_foto;
            $file->move(public_path() . '/imgs/maquinas/', $nom_foto);
        }

        $nueva_maquina->save();
        return response()->JSON([
            'sw' => true,
            'maquina' => $nueva_maquina,
            'msj' => 'El registro se realizó de forma correcta',
        ], 200);
    }

    public function update(Request $request, Maquina $maquina)
    {
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpeg,jpg,png|max:2048';
        }
        if (isset($request->fecha_incorporacion) && $request->fecha_incorporacion != "") {
            $this->validacion['fecha_incorporacion'] = 'date';
        }
        if (isset($request->cantidad) && $request->cantidad != "") {
            $this->validacion['cantidad'] = 'numeric|min:1';
        }

        $request->validate($this->validacion, $this->mensajes);
        $request["codigo"] = $maquina->id;
        $maquina->update(array_map('mb_strtoupper', $request->except('foto', 'fecha_incorporacion', "cantidad")));

        if (!$request->fecha_incorporacion || $request->fecha_incorporacion == "") {
            $maquina->fecha_incorporacion = null;
        } else {
            $maquina->fecha_incorporacion = $request->fecha_incorporacion;
        }
        if (!$request->cantidad || $request->cantidad == "") {
            $maquina->cantidad = null;
        } else {
            $maquina->cantidad = $request->cantidad;
        }

        if ($request->hasFile('foto')) {
            $antiguo = $maquina->foto;
            if ($antiguo != 'default.png') {
                \File::delete(public_path() . '/imgs/maquinas/' . $antiguo);
            }
            $file = $request->foto;
            $nom_foto = time() . '_' . $maquina->maquina . '.' . $file->getClientOriginalExtension();
            $maquina->foto = $nom_foto;
            $file->move(public_path() . '/imgs/maquinas/', $nom_foto);
        }
        $maquina->save();
        return response()->JSON([
            'sw' => true,
            'maquina' => $maquina,
            'msj' => 'El registro se actualizó de forma correcta'
        ], 200);
    }

    public function show(Maquina $maquina)
    {
        return response()->JSON([
            'sw' => true,
            'maquina' => $maquina
        ], 200);
    }

    public function destroy(Maquina $maquina)
    {
        $antiguo = $maquina->foto;
        if ($antiguo != 'default.png') {
            \File::delete(public_path() . '/imgs/maquinas/' . $antiguo);
        }
        $maquina->delete();
        return response()->JSON([
            'sw' => true,
            'msj' => 'El registro se eliminó correctamente'
        ], 200);
    }
}
