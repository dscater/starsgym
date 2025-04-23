<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\DetalleVenta;
use Phpml\Regression\LeastSquares;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrediccionController extends Controller
{
    /**
     * Entrenamiento ventas
     *
     * @return void
     */
    private function entrenamientoVentas()
    {
        $dataset = [];
        $targets = [];

        //obtener los registros de ventas
        $ventas = DetalleVenta::all();
        foreach ($ventas as $venta) {
            $fecha = Carbon::parse($venta->fecha)->timestamp;
            $producto_id = $venta->producto_id;

            $dataset[] = [$producto_id, $fecha];
            $targets[] = $venta->subtotal;
        }

        // Entrenar el modelo de regresión
        $model = new LeastSquares();
        $model->train($dataset, $targets);

        // retornar el modelo
        return $model;
    }

    /**
     * Prediccion de la venta de producto
     *
     * @param [type] $modelData
     * @param [type] $producto_id
     * @param [type] $fechaInicio
     * @param [type] $fechaFin
     * @return void
     */
    private function predecirVenta($modelData, $producto_id, $fechaInicio, $fechaFin)
    {
        // Cargar el modelo entrenado
        $model = new LeastSquares();
        $model->train($modelData['dataset'], $modelData['targets']);

        // Iterar sobre el rango de fechas y hacer predicciones
        for ($fecha = $fechaInicio; $fecha->lte($fechaFin); $fecha->addDay()) {
            $timestamp = $fecha->timestamp;
            $subtotal_predicho = $model->predict([$producto_id, $timestamp]);
            $subtotal_predicho = round($subtotal_predicho, 2);
        }

        return $subtotal_predicho;
    }

    /**
     * Entrenamiento cobros
     *
     * @return void
     */
    private function entrenamientoCobros()
    {
        $dataset = [];
        $targets = [];

        //obtener los registros de cobros
        $cobros = Cobro::all();
        foreach ($cobros as $cobro) {
            $fecha = Carbon::parse($cobro->fecha)->timestamp;
            $plan_id = $cobro->plan_id;

            $dataset[] = [$plan_id, $fecha];
            $targets[] = $cobro->inscripcion->plan->costo;
        }

        // Entrenar el modelo de regresión
        $model = new LeastSquares();
        $model->train($dataset, $targets);

        // retornar el modelo
        return $model;
    }

    /**
     * Prediccion del cobro del plan
     *
     * @param [type] $modelData
     * @param [type] $plan_id
     * @param [type] $fechaInicio
     * @param [type] $fechaFin
     * @return void
     */
    private function predecirCobros($modelData, $plan_id, $fechaInicio, $fechaFin)
    {
        // Cargar el modelo entrenado
        $model = new LeastSquares();
        $model->train($modelData['dataset'], $modelData['targets']);

        // Iterar sobre el rango de fechas y hacer predicciones
        for ($fecha = $fechaInicio; $fecha->lte($fechaFin); $fecha->addDay()) {
            $timestamp = $fecha->timestamp;
            $subtotal_predicho = $model->predict([$plan_id, $timestamp]);
            $subtotal_predicho = round($subtotal_predicho, 2);
        }

        return $subtotal_predicho;
    }


    public function grafico_ventas(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $filtro =  $request->filtro;

        $productos = Producto::where("sucursal_id", $sucursal_id)->get();
        $data = [];
        foreach ($productos as $producto) {
            $cantidad = 0;
            if ($filtro == 'Rango de fechas') {
                // entrenar el modelo
                $modelo = $this->entrenamientoVentas();

                //obtener los datos
                $cantidad = $this->predecirVenta($modelo, $producto->id, $fecha_ini, $fecha_fin);
            } else {
                $cantidad = DetalleVenta::where("producto_id", $producto->id)->sum("subtotal");
            }

            //agregar la cantidad
            $data[] = [$producto->nombre, $cantidad ? (float)$cantidad : 0];
        }

        $fecha = date("d/m/Y");
        return response()->JSON([
            "sw" => true,
            "datos" => $data,
            "fecha" => $fecha
        ]);
    }
    public function grafico_cobros(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $filtro =  $request->filtro;

        $plans = Plan::where("sucursal_id", $sucursal_id)->get();
        $data = [];
        foreach ($plans as $plan) {
            $cantidad = 0;
            if ($filtro == 'Rango de fechas') {
                // entrenar el modelo
                $modelo = $this->entrenamientoCobros();
                //obtener los datos
                $cantidad = $this->predecirCobros($modelo, $plan->id, $fecha_ini, $fecha_fin);
            } else {
                $cantidad = Cobro::select("cobros")
                    ->join("inscripcions", "inscripcions.id", "=", "cobros.inscripcion_id")
                    ->join("plans", "plans.id", "=", "inscripcions.plan_id")
                    ->where("inscripcions.plan_id", $plan->id)
                    ->sum("plans.costo");
            }
            //agregar la cantidad
            $data[] = [$plan->nombre, $cantidad ? (float)$cantidad : 0];
        }

        $fecha = date("d/m/Y");
        return response()->JSON([
            "sw" => true,
            "datos" => $data,
            "fecha" => $fecha
        ]);
    }
}
