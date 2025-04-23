<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Maquina;
use App\Models\Producto;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public $validacion = [
        'nombre' => 'required|min:4|unique:categorias,nombre',
    ];

    public function index()
    {
        $categorias = Categoria::all();
        return response()->JSON(["categorias" => $categorias, "total" => count($categorias)]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion);
        $request["fecha_registro"] = date("Y-m-d");
        Categoria::create(array_map("mb_strtoupper", $request->all()));
        return response()->JSON(["sw" => true, "msj" => "El registro se almacenó correctamente"]);
    }

    public function show(Categoria $categoria)
    {
        return response()->JSON($categoria);
    }

    public function update(Categoria $categoria, Request $request)
    {
        $this->validacion['nombre'] = 'required|min:4|unique:categorias,nombre,' . $categoria->id;
        $request->validate($this->validacion);
        $categoria->update(array_map("mb_strtoupper", $request->all()));
        return response()->JSON(["sw" => true, "categoria" => $categoria, "msj" => "El registro se actualizó correctamente"]);
    }

    public function destroy(Categoria $categoria)
    {
        $existe = Maquina::where("categoria_id", $categoria->id)->get();
        if (count($existe) > 0) {
            return response()->JSON(["sw" => false, "categoria" => $categoria, "msj" => "No es posible eliminar el registro porque esta siendo utilizado"]);
        }
        $existe = Producto::where("categoria_id", $categoria->id)->get();
        if (count($existe) > 0) {
            return response()->JSON(["sw" => false, "categoria" => $categoria, "msj" => "No es posible eliminar el registro porque esta siendo utilizado"]);
        }

        $categoria->delete();
        return response()->JSON(["sw" => true, "categoria" => $categoria, "msj" => "El registro se actualizó correctamente"]);
    }
}
