<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public $validacion = [
        "sucursal_id" => "required",
        "nombre" => "required|min:3",
        "costo" => "required|numeric",
        "duracion" => "required|numeric",
        "todos" => "required"
    ];

    public function index()
    {
        $plans = Plan::with("sucursal")->get();
        if (Auth::user()->tipo != 'GERENTE') {
            $plans = Plan::with("sucursal")->where("sucursal_id", Auth::user()->sucursal_id)->get();
        }
        return response()->JSON(["plans" => $plans, "total" => count($plans)]);
    }

    public function plans_sucursal(Request $request)
    {
        $plans = Plan::with("sucursal")->where("sucursal_id", $request->id)->get();
        return response()->JSON($plans);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion);
        $request["fecha_registro"] = date("Y-m-d");
        Plan::create(array_map("mb_strtoupper", $request->all()));
        return response()->JSON(["sw" => true, "msj" => "El registro se almacenó correctamente"]);
    }

    public function show(Plan $plan)
    {
        return response()->JSON($plan);
    }

    public function update(Plan $plan, Request $request)
    {
        $request->validate($this->validacion);
        $plan->update(array_map("mb_strtoupper", $request->all()));
        return response()->JSON(["sw" => true, "plan" => $plan, "msj" => "El registro se actualizó correctamente"]);
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return response()->JSON(["sw" => true, "plan" => $plan, "msj" => "El registro se actualizó correctamente"]);
    }
}
