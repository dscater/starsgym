<?php

use App\Http\Controllers\AccesoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CobroController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EvaluacionFisicaController;
use App\Http\Controllers\IngresoProductoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MantenimientoMaquinaController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\NotificacionUserController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("control", function () {
    return view("control");
});

// LOGIN
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

// CONFIGURACIÓN
Route::get('/configuracion/getConfiguracion', [ConfiguracionController::class, 'getConfiguracion']);
Route::post('/configuracion/update', [ConfiguracionController::class, 'update']);

Route::prefix('admin')->group(function () {
    // USUARIOS
    Route::get('usuarios/getUsuario/{usuario}', [UserController::class, 'getUsuario']);
    Route::get('usuarios/userActual', [UserController::class, 'userActual']);
    Route::get('usuarios/getInfoBox', [UserController::class, 'getInfoBox']);
    Route::get('usuarios/getPermisos/{usuario}', [UserController::class, 'getPermisos']);
    Route::get('usuarios/getEncargadosRepresentantes', [UserController::class, 'getEncargadosRepresentantes']);
    Route::post('usuarios/actualizaContrasenia/{usuario}', [UserController::class, 'actualizaContrasenia']);
    Route::post('usuarios/actualizaFoto/{usuario}', [UserController::class, 'actualizaFoto']);
    Route::resource('usuarios', UserController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // SUCURSALES
    Route::resource('sucursals', SucursalController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // PLANES
    Route::get("plans/plans_sucursal", [PlanController::class, 'plans_sucursal']);
    Route::resource('plans', PlanController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // CLIENTES
    Route::get("clientes/clientes_sucursal", [ClienteController::class, 'clientes_sucursal']);
    Route::get("clientes/todos_clientes", [ClienteController::class, 'todos_clientes']);
    Route::post("clientes/descargar_declaracion/{cliente}", [ClienteController::class, 'descargar_declaracion']);
    Route::resource('clientes', ClienteController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // EMPLEADOS
    Route::get("empleados/cargos", [EmpleadoController::class, 'cargos']);
    Route::resource('empleados', EmpleadoController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // CATEGORIAS
    Route::resource('categorias', CategoriaController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // MAQUINAS
    Route::get("maquinas/maquinas_sucursal", [MaquinaController::class, 'maquinas_sucursal']);
    Route::resource('maquinas', MaquinaController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // MANTENIMIENTO MAQUINAS
    Route::get("mantenimiento_maquinas/fechas_sugeridas", [MantenimientoMaquinaController::class, 'fechas_sugeridas']);
    Route::resource('mantenimiento_maquinas', MantenimientoMaquinaController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // INSCRIPCIONES
    Route::put("inscripcions/pausar_plan/{inscripcion}", [InscripcionController::class, 'pausar_plan']);
    Route::get("inscripcions/getInfoInscripcion", [InscripcionController::class, 'getInfoInscripcion']);
    Route::resource('inscripcions', InscripcionController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // ACCESOS
    Route::resource('accesos', AccesoController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // COBROS
    Route::post("cobros/pdf/{cobro}", [CobroController::class, 'factura']);
    Route::resource('cobros', CobroController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // EVALUACION FISICA
    Route::post("evaluacion_fisicas/pdf/{evaluacion_fisica}", [EvaluacionFisicaController::class, 'pdf']);
    Route::resource('evaluacion_fisicas', EvaluacionFisicaController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // PRODUCTOS
    Route::get("productos/valida_stock", [ProductoController::class, 'valida_stock']);
    Route::get("productos/productos_sucursal", [ProductoController::class, 'productos_sucursal']);
    Route::resource('productos', ProductoController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // INGRESO PRODUCTOS
    Route::resource('ingreso_productos', IngresoProductoController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // VENTAS
    Route::post("ventas/pdf/{venta}", [VentaController::class, 'pdf']);
    Route::resource('ventas', VentaController::class)->only([
        'index',
        'store',
        'update',
        'destroy',
        'show'
    ]);

    // NOTIFICACION USERS
    Route::resource('notificacion_users', NotificacionUserController::class)->only([
        'index',
        'show'
    ]);

    // REPORTES
    Route::post('reportes/usuarios', [ReporteController::class, 'usuarios']);
    Route::post('reportes/clientes', [ReporteController::class, 'clientes']);
    Route::post('reportes/empleados', [ReporteController::class, 'empleados']);
    Route::post('reportes/maquinas', [ReporteController::class, 'maquinas']);
    Route::post('reportes/mantenimiento_maquinas', [ReporteController::class, 'mantenimiento_maquinas']);
    Route::post('reportes/inscripcions', [ReporteController::class, 'inscripcions']);
    Route::post('reportes/accesos', [ReporteController::class, 'accesos']);
    Route::post('reportes/cobros', [ReporteController::class, 'cobros']);
    Route::post('reportes/productos', [ReporteController::class, 'productos']);
    Route::post('reportes/ingreso_productos', [ReporteController::class, 'ingreso_productos']);
    Route::post('reportes/stock_productos', [ReporteController::class, 'stock_productos']);
    Route::post('reportes/venta_productos', [ReporteController::class, 'venta_productos']);
    Route::post('reportes/grafico_ventas', [ReporteController::class, 'grafico_ventas']);
    Route::post('reportes/grafico_cobros', [ReporteController::class, 'grafico_cobros']);
});

// ---------------------------------------
Route::get('/{optional?}', function () {
    return view('app');
})->name('base_path')->where('optional', '.*');
