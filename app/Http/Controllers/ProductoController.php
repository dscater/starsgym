<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public $validacion = [
        "nombre" => "required",
        "categoria_id" => "required",
        "precio" => "required|numeric",
        "sucursal_id" => "required",
    ];

    public $mensajes = [
        'sucursal_id.required' => 'Este campo es obligatorio',
    ];

    public function index(Request $request)
    {
        $productos = Producto::with("categoria")->with("sucursal")->get();
        if (Auth::user()->tipo != 'GERENTE') {
            $productos = Producto::with("categoria")->with("sucursal")->where("sucursal_id", Auth::user()->sucursal_id)->get();
        }

        return response()->JSON(['productos' => $productos, 'total' => count($productos)], 200);
    }

    public function productos_sucursal(Request $request)
    {
        $productos = Producto::with("sucursal")->where("sucursal_id", $request->id)->get();
        return response()->JSON($productos);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpeg,jpg,png|max:2048';
        }
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        $request['stock_actual'] = 0;
        $request['ingresos'] = 0;
        $request['salidas'] = 0;
        // CREAR EL PRODUCTO
        $nuevo_producto = Producto::create(array_map('mb_strtoupper', $request->except('foto')));
        $nuevo_producto->foto = 'default.png';
        if ($request->hasFile('foto')) {
            $file = $request->foto;
            $nom_foto = time() . '_' . str_replace(" ", "_", $nuevo_producto->nombre) . '.' . $file->getClientOriginalExtension();
            $nuevo_producto->foto = $nom_foto;
            $file->move(public_path() . '/imgs/productos/', $nom_foto);
        }
        $nuevo_producto->save();
        return response()->JSON([
            'sw' => true,
            'producto' => $nuevo_producto,
            'msj' => 'El registro se realizó de forma correcta',
        ], 200);
    }

    public function update(Request $request, Producto $producto)
    {
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpeg,jpg,png|max:2048';
        }

        $request->validate($this->validacion, $this->mensajes);
        $producto->update(array_map('mb_strtoupper', $request->except('foto')));
        if ($request->hasFile('foto')) {
            $antiguo = $producto->foto;
            if ($antiguo != 'default.png') {
                \File::delete(public_path() . '/imgs/productos/' . $antiguo);
            }
            $file = $request->foto;
            $nom_foto = time() . '_' . str_replace(" ", "_", $producto->nombre) . '.' . $file->getClientOriginalExtension();
            $producto->foto = $nom_foto;
            $file->move(public_path() . '/imgs/productos/', $nom_foto);
        }
        $producto->save();
        return response()->JSON([
            'sw' => true,
            'producto' => $producto,
            'msj' => 'El registro se actualizó de forma correcta'
        ], 200);
    }

    public function show(Producto $producto)
    {
        return response()->JSON([
            'sw' => true,
            'producto' => $producto
        ], 200);
    }

    public function destroy(Producto $producto)
    {
        $antiguo = $producto->foto;
        if ($antiguo != 'default.png') {
            \File::delete(public_path() . '/imgs/productos/' . $antiguo);
        }
        $producto->delete();
        return response()->JSON([
            'sw' => true,
            'msj' => 'El registro se eliminó correctamente'
        ], 200);
    }

    public function valida_stock(Request $request)
    {
        $cantidad = $request->cantidad;
        $producto = Producto::find($request->id);

        if ($producto->stock_actual >= $cantidad) {
            return response()->JSON(
                [
                    "sw" => true,
                    "producto" => $producto,
                ]
            );
        }
        return response()->JSON(
            [
                "sw" => false,
                "msj" => "La cantidad solicitada para el producto <strong>" . $producto->nombre . "</strong>, supera al stock actual disponible.<br/> Stock actual: <b>" . $producto->stock_actual . " unidades</b>"
            ]
        );
    }
}
