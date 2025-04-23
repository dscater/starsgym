<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use App\Models\Cliente;
use App\Models\Cobro;
use App\Models\DetalleVenta;
use App\Models\Empleado;
use App\Models\IngresoProducto;
use App\Models\Inscripcion;
use App\Models\MantenimientoMaquina;
use App\Models\Maquina;
use App\Models\Plan;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PDF;

class ReporteController extends Controller
{
    public function usuarios(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);

        $sucursal_id =  $request->sucursal_id;
        $filtro =  $request->filtro;
        $usuarios = User::where('id', '!=', 1)->where("sucursal_id", $sucursal_id)
            ->orderBy("created_at", "desc")
            ->get();
        if ($filtro == 'Rango de fechas') {
            $request->validate([
                'fecha_ini' => 'required|date',
                'fecha_fin' => 'required|date',
            ]);
            $usuarios = User::where('id', '!=', 1)->where("sucursal_id", $sucursal_id)->whereBetween('fecha_registro', [$request->fecha_ini, $request->fecha_fin])
                ->orderBy("created_at", "desc")
                ->get();
        }

        if ($filtro == 'Tipo de usuario') {
            $request->validate([
                'tipo' => 'required',
            ]);
            $usuarios = User::where('id', '!=', 1)->where("sucursal_id", $sucursal_id)->where('tipo', $request->tipo)
                ->orderBy("created_at", "desc")
                ->get();
        }

        $pdf = PDF::loadView('reportes.usuarios', compact('usuarios'))->setPaper('legal', 'landscape');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->download('Usuarios.pdf');
    }

    public function clientes(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $plan_id =  $request->plan_id;
        $disciplina =  $request->disciplina;
        $filtro =  $request->filtro;
        $clientes = Cliente::where("sucursal_id", $sucursal_id)->orderBy("created_at", "desc")->get();
        if ($filtro == 'Rango de fechas') {
            $request->validate([
                'fecha_ini' => 'required|date',
                'fecha_fin' => 'required|date',
            ]);
            $clientes = Cliente::where("sucursal_id", $sucursal_id)->whereBetween('fecha_registro', [$request->fecha_ini, $request->fecha_fin])->orderBy("created_at", "desc")->get();
        }

        if ($filtro == 'Por disciplina') {
            $request->validate([
                'disciplina' => 'required',
            ]);
            $clientes = Cliente::select("clientes.*", "inscripcions.disciplina")
                ->join("inscripcions", "inscripcions.cliente_id", "=", "clientes.id")
                ->where("clientes.sucursal_id", $sucursal_id)
                ->where("inscripcions.disciplina", $disciplina)
                ->where("inscripcions.fecha_fin", ">=", date("Y-m-d"))
                ->orderBy("clientes.created_at", "desc")->get();
        }

        if ($filtro == 'Por plan') {
            $request->validate([
                'plan_id' => 'required',
            ]);
            $clientes = Cliente::select("clientes.*", "inscripcions.disciplina")
                ->join("inscripcions", "inscripcions.cliente_id", "=", "clientes.id")
                ->where("clientes.sucursal_id", $sucursal_id)
                ->where("inscripcions.plan_id", $plan_id)
                ->where("inscripcions.fecha_fin", ">=", date("Y-m-d"))
                ->orderBy("clientes.created_at", "desc")->get();
        }

        $pdf = PDF::loadView('reportes.clientes', compact('clientes'))->setPaper('legal', 'landscape');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->download('clientes.pdf');
    }
    public function empleados(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $cargo =  mb_strtoupper($request->cargo);
        $filtro =  $request->filtro;
        $empleados = Empleado::where("sucursal_id", $sucursal_id)->orderBy("created_at", "desc")->get();
        if ($filtro == 'Rango de fechas') {
            $request->validate([
                'fecha_ini' => 'required|date',
                'fecha_fin' => 'required|date',
            ]);
            $empleados = Empleado::where("sucursal_id", $sucursal_id)->whereBetween('fecha_registro', [$request->fecha_ini, $request->fecha_fin])->orderBy("created_at", "desc")->get();
        }

        if ($filtro == 'Cargo') {
            $request->validate(['cargo' => 'required']);
            $empleados = Empleado::where("sucursal_id", $sucursal_id)->where('cargo', $cargo)->orderBy("created_at", "desc")->get();
        }

        $pdf = PDF::loadView('reportes.empleados', compact('empleados'))->setPaper('legal', 'landscape');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('empleados.pdf');
    }
    public function maquinas(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $categoria_id =  $request->categoria_id;
        $filtro =  $request->filtro;
        $estado =  $request->estado;
        $estados = [
            "ACTIVOS" => "ACTIVO",
            "INACTIVOS" => "INACTIVO"
        ];
        $txt_estado = $estados[$estado];

        $maquinas = Maquina::where("sucursal_id", $sucursal_id)
            ->where("estado", $txt_estado)
            ->orderBy("created_at", "desc")->get();

        if ($filtro == 'Categoría') {
            $request->validate(['categoria_id' => 'required']);
            $maquinas = Maquina::where("sucursal_id", $sucursal_id)
                ->where("estado", $txt_estado)
                ->where('categoria_id', $categoria_id)->orderBy("created_at", "desc")->get();
        }

        $pdf = PDF::loadView('reportes.maquinas', compact('maquinas'))->setPaper('legal', 'landscape');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('maquinas.pdf');
    }
    public function mantenimiento_maquinas(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $maquina_id =  $request->maquina_id;
        $filtro =  $request->filtro;
        $mantenimiento_maquinas = MantenimientoMaquina::where("sucursal_id", $sucursal_id)->orderBy("created_at", "desc")->get();

        if ($filtro == 'Máquina') {
            $request->validate(['maquina_id' => 'required']);
            $mantenimiento_maquinas = MantenimientoMaquina::where("sucursal_id", $sucursal_id)->where('maquina_id', $maquina_id)->orderBy("created_at", "desc")->get();
        }

        $pdf = PDF::loadView('reportes.mantenimiento_maquinas', compact('mantenimiento_maquinas'))->setPaper('legal', 'landscape');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('mantenimiento_maquinas.pdf');
    }
    public function inscripcions(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $plan_id =  $request->plan_id;
        $filtro =  $request->filtro;
        $inscripcions = Inscripcion::where("sucursal_id", $sucursal_id)->orderBy("created_at", "desc")->get();

        if ($filtro == 'Rango de fechas') {
            $request->validate([
                'fecha_ini' => 'required|date',
                'fecha_fin' => 'required|date',
            ]);
            $inscripcions = Inscripcion::where("sucursal_id", $sucursal_id)->whereBetween('fecha_inscripcion', [$request->fecha_ini, $request->fecha_fin])->orderBy("created_at", "desc")->get();
        }

        if ($filtro == 'Seleccionar Plan') {
            $request->validate(['plan_id' => 'required']);
            $inscripcions = Inscripcion::where("sucursal_id", $sucursal_id)->where('plan_id', $plan_id)->orderBy("created_at", "desc")->get();
        }

        $pdf = PDF::loadView('reportes.inscripcions', compact('inscripcions'))->setPaper('legal', 'landscape');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('inscripcions.pdf');
    }
    public function accesos(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $cliente_id =  $request->cliente_id;
        $filtro =  $request->filtro;
        $accesos = Acceso::where("sucursal_id", $sucursal_id)->orderBy("created_at", "desc")->get();

        if ($filtro == 'Rango de fechas') {
            $request->validate([
                'fecha_ini' => 'required|date',
                'fecha_fin' => 'required|date',
            ]);
            $accesos = Acceso::where("sucursal_id", $sucursal_id)->whereBetween('fecha_registro', [$request->fecha_ini, $request->fecha_fin])->orderBy("created_at", "desc")->get();
        }

        if ($filtro == 'Cliente') {
            $request->validate(['cliente_id' => 'required']);
            $accesos = Acceso::where("sucursal_id", $sucursal_id)->where('cliente_id', $cliente_id)->orderBy("created_at", "desc")->get();
        }

        $pdf = PDF::loadView('reportes.accesos', compact('accesos'))->setPaper('legal', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('accesos.pdf');
    }
    public function cobros(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $plan_id =  $request->plan_id;
        $cliente_id =  $request->cliente_id;
        $filtro =  $request->filtro;

        if ($sucursal_id != 'TODOS') {
            // POR SUCURSAL
            $cobros = Cobro::where("sucursal_id", $sucursal_id)->orderBy("created_at", "desc")->get();
            if ($filtro == 'Rango de fechas') {
                $request->validate([
                    'fecha_ini' => 'required|date',
                    'fecha_fin' => 'required|date',
                ]);
                $cobros = Cobro::where("sucursal_id", $sucursal_id)->whereBetween('fecha_registro', [$request->fecha_ini, $request->fecha_fin])->orderBy("created_at", "desc")->get();
            }

            if ($filtro == 'Cliente') {
                $request->validate(['cliente_id' => 'required']);
                $cobros = Cobro::where("sucursal_id", $sucursal_id)->where('cliente_id', $cliente_id)->orderBy("created_at", "desc")->get();
            }

            if ($filtro == 'Plan') {
                $request->validate([
                    'plan_id' => 'required',
                    'fecha_ini2' => 'required|date',
                    'fecha_fin2' => 'required|date',
                ]);
                $cobros = Cobro::select("cobros.*")
                    ->join("inscripcions", "inscripcions.id", "=", "cobros.inscripcion_id")
                    ->where("cobros.sucursal_id", $sucursal_id)
                    ->where('inscripcions.plan_id', $plan_id)
                    ->whereBetween('cobros.fecha_registro', [$request->fecha_ini2, $request->fecha_fin2])
                    ->orderBy("cobros.created_at", "desc")->get();
            }
        } else {
            // TODOS
            $cobros = Cobro::orderBy("created_at", "desc")->get();
        }


        $pdf = PDF::loadView('reportes.cobros', compact('cobros'))->setPaper('legal', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('cobros.pdf');
    }
    public function productos(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $categoria_id =  $request->categoria_id;
        $filtro =  $request->filtro;
        $productos = Producto::where("sucursal_id", $sucursal_id)->orderBy("created_at", "desc")->get();

        if ($filtro == 'Categoría' && $categoria_id != 'todos') {
            $request->validate(['categoria_id' => 'required']);
            $productos = Producto::where("sucursal_id", $sucursal_id)
                ->where('categoria_id', $categoria_id)
                ->orderBy("created_at", "desc")->get();
        }

        $pdf = PDF::loadView('reportes.productos', compact('productos'))->setPaper('legal', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('productos.pdf');
    }
    public function ingreso_productos(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $producto_id =  $request->producto_id;
        $categoria_id =  $request->categoria_id;
        $filtro =  $request->filtro;
        $ingreso_productos = IngresoProducto::where("sucursal_id", $sucursal_id)->orderBy("created_at", "desc")->get();

        if ($filtro == 'Categoría' && $categoria_id != 'todos') {
            $request->validate(['categoria_id' => 'required']);
            $ingreso_productos = IngresoProducto::select("ingreso_productos.*")
                ->join("productos", "productos.id", "=", "ingreso_productos.producto_id")
                ->where("ingreso_productos.sucursal_id", $sucursal_id)
                ->where('productos.categoria_id', $categoria_id)
                ->orderBy("ingreso_productos.created_at", "desc")->get();
        }

        if ($filtro == 'Producto' && $producto_id != 'todos') {
            $request->validate(['producto_id' => 'required']);
            $ingreso_productos = IngresoProducto::where("sucursal_id", $sucursal_id)
                ->where('producto_id', $producto_id)
                ->orderBy("created_at", "desc")->get();
        }

        $pdf = PDF::loadView('reportes.ingreso_productos', compact('ingreso_productos'))->setPaper('legal', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('ingreso_productos.pdf');
    }
    public function stock_productos(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $productos = Producto::where("sucursal_id", $sucursal_id)->orderBy("created_at", "desc")->get();

        $pdf = PDF::loadView('reportes.stock_productos', compact('productos'))->setPaper('legal', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('stock_productos.pdf');
    }
    public function venta_productos(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $producto_id =  $request->producto_id;
        $categoria_id =  $request->categoria_id;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $filtro =  $request->filtro;

        $detalle_ventas = DetalleVenta::select("detalle_ventas.*")
            ->join("ventas", "ventas.id", "=", "detalle_ventas.venta_id")
            ->where("ventas.sucursal_id", $sucursal_id)->orderBy("ventas.created_at", "desc")->get();


        if ($filtro == 'Categoría' && $categoria_id != 'todos') {
            $detalle_ventas = DetalleVenta::select("detalle_ventas.*")
                ->join("ventas", "ventas.id", "=", "detalle_ventas.venta_id")
                ->join("productos", "productos.id", "=", "detalle_ventas.producto_id")
                ->where("productos.categoria_id", $categoria_id)
                ->where("ventas.sucursal_id", $sucursal_id)
                ->orderBy("ventas.created_at", "desc")->get();
        }

        if ($filtro == 'Producto' && $producto_id != 'todos') {
            $detalle_ventas = DetalleVenta::select("detalle_ventas.*")
                ->join("ventas", "ventas.id", "=", "detalle_ventas.venta_id")
                ->where("detalle_ventas.producto_id", $producto_id)
                ->where("ventas.sucursal_id", $sucursal_id)
                ->orderBy("ventas.created_at", "desc")->get();
        }

        if ($filtro == 'Rango de fechas') {
            $detalle_ventas = DetalleVenta::select("detalle_ventas.*")
                ->join("ventas", "ventas.id", "=", "detalle_ventas.venta_id")
                ->whereBetween("ventas.fecha", [$fecha_ini, $fecha_fin])
                ->orderBy("ventas.created_at", "desc")->get();
        }

        $pdf = PDF::loadView('reportes.venta_productos', compact('detalle_ventas'))->setPaper('legal', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('venta_productos.pdf');
    }
    public function grafico_ventas(Request $request)
    {
        $request->validate(['sucursal_id' => 'required']);
        $sucursal_id =  $request->sucursal_id;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $fecha_actual = date("Y-m-d");
        $filtro =  $request->filtro;

        $productos = Producto::where("sucursal_id", $sucursal_id)->get();
        $data = [];
        foreach ($productos as $producto) {
            $cantidad = 0;
            if ($filtro == 'Rango de fechas') {

                $cantidad = 0;
                if ($fecha_ini > $fecha_actual) {
                    $array_fechas = $this->getFechas($fecha_ini);
                    $c1 = DetalleVenta::select("detalle_ventas")
                        ->join("ventas", "ventas.id", "=", "detalle_ventas.venta_id")
                        ->where("producto_id", $producto->id)
                        ->where("fecha", "LIKE", "$array_fechas[0]%")
                        ->sum("detalle_ventas.subtotal");
                    $c2 = DetalleVenta::select("detalle_ventas")
                        ->join("ventas", "ventas.id", "=", "detalle_ventas.venta_id")
                        ->where("producto_id", $producto->id)
                        ->where("fecha", "LIKE", "$array_fechas[1]%")
                        ->sum("detalle_ventas.subtotal");
                    $c3 = DetalleVenta::select("detalle_ventas")
                        ->join("ventas", "ventas.id", "=", "detalle_ventas.venta_id")
                        ->where("producto_id", $producto->id)
                        ->where("fecha", "LIKE", "$array_fechas[2]%")
                        ->sum("detalle_ventas.subtotal");
                    $t = (float)$c1 + (float)$c2 + (float) $c3;
                    $t =  $t / 3;

                    if ($t <= 0) {
                        $cantidad = DetalleVenta::select("detalle_ventas")
                            ->join("ventas", "ventas.id", "=", "detalle_ventas.venta_id")
                            ->where("producto_id", $producto->id)
                            ->sum("detalle_ventas.subtotal");

                        $cont = DetalleVenta::select("detalle_ventas")
                            ->join("ventas", "ventas.id", "=", "detalle_ventas.venta_id")
                            ->where("producto_id", $producto->id)->count();
                        // if ($cont < 3) {
                        //     $cont = 3;
                        // }

                        $cantidad = $cantidad / $cont;
                    } else {
                        $cantidad = $t;
                    }
                } else {
                    $cantidad = DetalleVenta::select("detalle_ventas")
                        ->join("ventas", "ventas.id", "=", "detalle_ventas.venta_id")
                        ->where("producto_id", $producto->id)
                        ->whereBetween("fecha", [$fecha_ini, $fecha_fin])
                        ->sum("detalle_ventas.subtotal");
                }
                // $cantidad = DetalleVenta::select("detalle_ventas")
                //     ->join("ventas", "ventas.id", "=", "detalle_ventas.venta_id")
                //     ->where("producto_id", $producto->id)
                //     ->whereBetween("fecha", [$fecha_ini, $fecha_fin])
                //     ->sum("detalle_ventas.subtotal");
            } else {
                $cantidad = DetalleVenta::where("producto_id", $producto->id)->sum("subtotal");
            }
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
        $fecha_actual = date("Y-m-d");
        $filtro =  $request->filtro;

        $plans = Plan::where("sucursal_id", $sucursal_id)->get();
        $data = [];
        foreach ($plans as $plan) {
            $cantidad = 0;
            if ($filtro == 'Rango de fechas') {
                $cantidad = 0;
                if ($fecha_ini > $fecha_actual) {
                    $array_fechas = $this->getFechas($fecha_ini);
                    $c1 = Cobro::select("cobros")
                        ->join("inscripcions", "inscripcions.id", "=", "cobros.inscripcion_id")
                        ->join("plans", "plans.id", "=", "inscripcions.plan_id")
                        ->where("inscripcions.plan_id", $plan->id)
                        ->where("fecha_cobro", "LIKE", "$array_fechas[0]%")
                        ->sum("plans.costo");
                    $c2 = Cobro::select("cobros")
                        ->join("inscripcions", "inscripcions.id", "=", "cobros.inscripcion_id")
                        ->join("plans", "plans.id", "=", "inscripcions.plan_id")
                        ->where("inscripcions.plan_id", $plan->id)
                        ->where("fecha_cobro", "LIKE", "$array_fechas[1]%")
                        ->sum("plans.costo");
                    $c3 = Cobro::select("cobros")
                        ->join("inscripcions", "inscripcions.id", "=", "cobros.inscripcion_id")
                        ->join("plans", "plans.id", "=", "inscripcions.plan_id")
                        ->where("inscripcions.plan_id", $plan->id)
                        ->where("fecha_cobro", "LIKE", "$array_fechas[2]%")
                        ->sum("plans.costo");
                    $t = (float)$c1 + (float)$c2 + (float) $c3;
                    $t =  $t / 3;
                    if ($t <= 0) {
                        $cantidad = Cobro::select("cobros")
                            ->join("inscripcions", "inscripcions.id", "=", "cobros.inscripcion_id")
                            ->join("plans", "plans.id", "=", "inscripcions.plan_id")
                            ->where("inscripcions.plan_id", $plan->id)
                            ->sum("plans.costo");
                        $cont = Cobro::select("cobros")
                            ->join("inscripcions", "inscripcions.id", "=", "cobros.inscripcion_id")
                            ->join("plans", "plans.id", "=", "inscripcions.plan_id")
                            ->where("inscripcions.plan_id", $plan->id)
                            ->count();
                            
                        $cantidad = $cantidad / $cont;
                    } else {
                        $cantidad = $t;
                    }
                } else {
                    $cantidad = Cobro::select("cobros")
                        ->join("inscripcions", "inscripcions.id", "=", "cobros.inscripcion_id")
                        ->join("plans", "plans.id", "=", "inscripcions.plan_id")
                        ->where("inscripcions.plan_id", $plan->id)
                        ->whereBetween("fecha_cobro", [$fecha_ini, $fecha_fin])
                        ->sum("plans.costo");
                }

                // $cantidad = Cobro::select("cobros")
                //     ->join("inscripcions", "inscripcions.id", "=", "cobros.inscripcion_id")
                //     ->join("plans", "plans.id", "=", "inscripcions.plan_id")
                //     ->where("inscripcions.plan_id", $plan->id)
                //     ->whereBetween("fecha_cobro", [$fecha_ini, $fecha_fin])
                //     ->sum("plans.costo");
            } else {
                $cantidad = Cobro::select("cobros")
                    ->join("inscripcions", "inscripcions.id", "=", "cobros.inscripcion_id")
                    ->join("plans", "plans.id", "=", "inscripcions.plan_id")
                    ->where("inscripcions.plan_id", $plan->id)
                    ->sum("plans.costo");
            }
            $data[] = [$plan->nombre, $cantidad ? (float)$cantidad : 0];
        }

        $fecha = date("d/m/Y");
        return response()->JSON([
            "sw" => true,
            "datos" => $data,
            "fecha" => $fecha
        ]);
    }

    private function getFechas($value)
    {
        $fecha1 = date("Y-m", strtotime($value . " -3 month"));
        $fecha2 = date("Y-m", strtotime($value . " -2 month"));
        $fecha3 = date("Y-m", strtotime($value . " -1 month"));

        return [$fecha1, $fecha2, $fecha3];
    }
}
