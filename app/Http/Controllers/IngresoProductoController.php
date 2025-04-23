<?php

namespace App\Http\Controllers;

use App\Models\IngresoProducto;
use App\Models\Producto;
use Illuminate\Http\Request;

class IngresoProductoController extends Controller
{
    public $validacion = [
        "sucursal_id" => "required",
        "producto_id" => "required",
        "cantidad" => "required|numeric",
        "fecha_ingreso" => "required|date",
    ];

    public function index()
    {
        $ingreso_productos = IngresoProducto::with("sucursal")->with("producto")->get();
        return response()->JSON(["ingreso_productos" => $ingreso_productos, "total" => count($ingreso_productos)]);
    }

    public function ingreso_productos_sucursal(Request $request)
    {
        $ingreso_productos = IngresoProducto::with("sucursal")->where("sucursal_id", $request->id)->get();
        return response()->JSON($ingreso_productos);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion);
        $request["fecha_registro"] = date("Y-m-d");
        $ingreso_producto = IngresoProducto::create(array_map("mb_strtoupper", $request->all()));

        $producto = Producto::find($ingreso_producto->producto_id);
        $producto->stock_actual = (float) $producto->stock_actual + (float)$ingreso_producto->cantidad;
        $producto->ingresos = (float) $producto->ingresos + (float)$ingreso_producto->cantidad;
        $producto->save();

        return response()->JSON(["sw" => true, "msj" => "El registro se almacenó correctamente"]);
    }

    public function show(IngresoProducto $ingreso_producto)
    {
        return response()->JSON($ingreso_producto);
    }

    public function update(IngresoProducto $ingreso_producto, Request $request)
    {
        $request->validate($this->validacion);

        $producto = Producto::find($ingreso_producto->producto_id);
        $producto->stock_actual = (float) $producto->stock_actual - (float)$ingreso_producto->cantidad;
        $producto->ingresos = (float) $producto->ingresos - (float)$ingreso_producto->cantidad;
        $producto->save();

        $ingreso_producto->update(array_map("mb_strtoupper", $request->except("fecha_vencimiento")));
        if ($request->fecha_vencimiento) {
            $ingreso_producto->fecha_vencimiento = $request->fecha_vencimiento;
        } else {
            $ingreso_producto->fecha_vencimiento = null;
        }
        $ingreso_producto->save();

        $producto = Producto::find($ingreso_producto->producto_id);
        $producto->stock_actual = (float) $producto->stock_actual + (float)$ingreso_producto->cantidad;
        $producto->ingresos = (float) $producto->ingresos + (float)$ingreso_producto->cantidad;
        $producto->save();

        return response()->JSON(["sw" => true, "ingreso_producto" => $ingreso_producto, "msj" => "El registro se actualizó correctamente"]);
    }

    public function destroy(IngresoProducto $ingreso_producto)
    {
        $producto = Producto::find($ingreso_producto->producto_id);
        $producto->stock_actual = (float) $producto->stock_actual - (float)$ingreso_producto->cantidad;
        $producto->ingresos = (float) $producto->ingresos - (float)$ingreso_producto->cantidad;
        $producto->save();

        $ingreso_producto->delete();
        return response()->JSON(["sw" => true, "ingreso_producto" => $ingreso_producto, "msj" => "El registro se actualizó correctamente"]);
    }
}
