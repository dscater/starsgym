<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public $validacion = [
        'nombre' => 'required|min:4|unique:sucursals,nombre',
        'dir' => 'nullable|min:4',
    ];

    public function index()
    {
        $sucursals = Sucursal::where("id", "!=", 1)->where("nombre", "!=", "*")->get();
        return response()->JSON(["sucursals" => $sucursals, "total" => count($sucursals)]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion);
        $request["fecha_registro"] = date("Y-m-d");
        Sucursal::create(array_map("mb_strtoupper", $request->all()));
        return response()->JSON(["sw" => true, "msj" => "El registro se almacenó correctamente"]);
    }

    public function show(Sucursal $sucursal)
    {
        return response()->JSON($sucursal);
    }

    public function update(Sucursal $sucursal, Request $request)
    {
        $this->validacion['nombre'] = 'required|min:4|unique:sucursals,nombre,' . $sucursal->id;
        $request->validate($this->validacion);
        $sucursal->update(array_map("mb_strtoupper", $request->all()));
        return response()->JSON(["sw" => true, "sucursal" => $sucursal, "msj" => "El registro se actualizó correctamente"]);
    }

    public function destroy(Sucursal $sucursal)
    {
        $sucursal->delete();
        return response()->JSON(["sw" => true, "sucursal" => $sucursal, "msj" => "El registro se actualizó correctamente"]);
    }
}
