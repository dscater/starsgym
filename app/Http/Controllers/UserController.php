<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Inscripcion;
use App\Models\Maquina;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $validacion = [

        "usuario" => "required|min:4",
        "codigo" => "required|min:4|unique:users,codigo",
        "correo" => "nullable|min:4",
        "tipo" => "required",
        "sucursal_id" => "required",
    ];

    public $mensajes = [
        'sucursal_id.required' => 'Este campo es obligatorio',
    ];

    public $permisos = [
        'GERENTE' => [
            'usuarios.index',
            'usuarios.create',
            'usuarios.edit',
            'usuarios.destroy',

            'sucursals.index',
            'sucursals.create',
            'sucursals.edit',
            'sucursals.destroy',

            'empleados.index',
            'empleados.create',
            'empleados.edit',
            'empleados.destroy',

            'clientes.index',
            'clientes.create',
            'clientes.edit',
            'clientes.destroy',

            'cobros.index',
            'cobros.create',
            'cobros.edit',
            'cobros.destroy',

            'inscripcions.index',
            'inscripcions.create',
            'inscripcions.edit',
            'inscripcions.destroy',

            "notificacion_users.index",

            'evaluacion_fisicas.index',
            'evaluacion_fisicas.create',
            'evaluacion_fisicas.edit',
            'evaluacion_fisicas.destroy',

            'ingreso_productos.index',
            'ingreso_productos.create',
            'ingreso_productos.edit',
            'ingreso_productos.destroy',

            'ventas.index',
            'ventas.create',
            'ventas.edit',
            'ventas.destroy',

            'productos.index',
            'productos.create',
            'productos.edit',
            'productos.destroy',

            'accesos.index',
            'accesos.create',
            'accesos.edit',
            'accesos.destroy',

            'categorias.index',
            'categorias.create',
            'categorias.edit',
            'categorias.destroy',

            'maquinas.index',
            'maquinas.create',
            'maquinas.edit',
            'maquinas.destroy',

            'mantenimiento_maquinas.index',
            'mantenimiento_maquinas.create',
            'mantenimiento_maquinas.edit',
            'mantenimiento_maquinas.destroy',

            'plans.index',
            'plans.create',
            'plans.edit',
            'plans.destroy',

            'configuracion.index',
            'configuracion.edit',

            "reportes.usuarios",
            "reportes.clientes",
            "reportes.empleados",
            "reportes.maquinas",
            "reportes.mantenimiento_maquinas",
            "reportes.inscripcions",
            "reportes.accesos",
            "reportes.cobros",
            "reportes.productos",
            "reportes.ingreso_productos",
            "reportes.stock_productos",
            "reportes.venta_productos",
            "reportes.grafico_ventas",
            "reportes.grafico_cobros",

        ],
        'ENCARGADO DE RECEPCIÓN' => [
            'plans.index',

            'clientes.index',
            'clientes.create',
            'clientes.edit',
            'clientes.destroy',

            'inscripcions.index',
            'inscripcions.create',
            'inscripcions.edit',
            'inscripcions.destroy',

            "notificacion_users.index",

            'accesos.index',
            'accesos.create',
            'accesos.edit',
            'accesos.destroy',

            'cobros.index',
            'cobros.create',
            'cobros.edit',
            'cobros.destroy',

            'productos.index',

            'ventas.index',
            'ventas.create',
            'ventas.edit',
            'ventas.destroy',

            "reportes.clientes",
            "reportes.accesos",
            "reportes.cobros",
            "reportes.productos",
            "reportes.stock_productos",
            "reportes.venta_productos",
            "reportes.grafico_ventas",
            "reportes.grafico_cobros",
        ],
        'ENTRENADOR' => [
            'plans.index',

            'mantenimiento_maquinas.index',
            'mantenimiento_maquinas.create',
            'mantenimiento_maquinas.edit',
            'mantenimiento_maquinas.destroy',

            'evaluacion_fisicas.index',
            'evaluacion_fisicas.create',
            'evaluacion_fisicas.edit',
            'evaluacion_fisicas.destroy',

            "reportes.clientes",
            "reportes.maquinas",
            "reportes.mantenimiento_maquinas",
            "reportes.inscripcions",
        ],
    ];


    public function index(Request $request)
    {
        $usuarios = User::where('id', '!=', 1)->get();
        return response()->JSON(['usuarios' => $usuarios, 'total' => count($usuarios)], 200);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpeg,jpg,png|max:2048';
        }
        $this->validacion['contrasenia'] = 'required|min:4';

        $request->validate($this->validacion, $this->mensajes);
        $request['password'] = "pass";
        $request['fecha_registro'] = date('Y-m-d');
        // CREAR EL USER
        $nuevo_usuario = User::create(array_map('mb_strtoupper', $request->except('foto')));
        $nuevo_usuario->password = Hash::make($request->contrasenia);
        $nuevo_usuario->save();
        $nuevo_usuario->foto = 'default.png';
        if ($request->hasFile('foto')) {
            $file = $request->foto;
            $nom_foto = time() . '_' . $nuevo_usuario->usuario . '.' . $file->getClientOriginalExtension();
            $nuevo_usuario->foto = $nom_foto;
            $file->move(public_path() . '/imgs/users/', $nom_foto);
        }

        $nuevo_usuario->save();
        return response()->JSON([
            'sw' => true,
            'usuario' => $nuevo_usuario,
            'msj' => 'El registro se realizó de forma correcta',
        ], 200);
    }

    public function update(Request $request, User $usuario)
    {
        $this->validacion['codigo'] = 'required|min:4|unique:users,codigo,' . $usuario->id;
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpeg,jpg,png|max:2048';
        }

        if (isset($request->contrasenia) && trim($request->contrasenia) != "") {
            $this->validacion['contrasenia'] = 'required|min:4';
        }

        $request->validate($this->validacion, $this->mensajes);
        $usuario->update(array_map('mb_strtoupper', $request->except('foto', 'password')));
        if (isset($request->contrasenia) && trim($request->contrasenia) != "") {
            $usuario->password = Hash::make($request->contrasenia);
            $usuario->save();
        }

        if ($request->hasFile('foto')) {
            $antiguo = $usuario->foto;
            if ($antiguo != 'default.png') {
                \File::delete(public_path() . '/imgs/users/' . $antiguo);
            }
            $file = $request->foto;
            $nom_foto = time() . '_' . $usuario->usuario . '.' . $file->getClientOriginalExtension();
            $usuario->foto = $nom_foto;
            $file->move(public_path() . '/imgs/users/', $nom_foto);
        }
        $usuario->save();
        return response()->JSON([
            'sw' => true,
            'usuario' => $usuario,
            'msj' => 'El registro se actualizó de forma correcta'
        ], 200);
    }

    public function show(User $usuario)
    {
        return response()->JSON([
            'sw' => true,
            'usuario' => $usuario
        ], 200);
    }

    public function actualizaContrasenia(User $usuario, Request $request)
    {
        $request->validate([
            'password_actual' => ['required', function ($attribute, $value, $fail) use ($usuario, $request) {
                if (!\Hash::check($request->password_actual, $usuario->password)) {
                    return $fail(__('La contraseña no coincide con la actual.'));
                }
            }],
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required|min:4'
        ]);

        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return response()->JSON([
            'sw' => true,
            'msj' => 'La contraseña se actualizó correctamente'
        ], 200);
    }

    public function actualizaFoto(User $usuario, Request $request)
    {
        if ($request->hasFile('foto')) {
            $antiguo = $usuario->foto;
            if ($antiguo != 'default.png') {
                \File::delete(public_path() . '/imgs/users/' . $antiguo);
            }
            $file = $request->foto;
            $nom_foto = time() . '_' . $usuario->usuario . '.' . $file->getClientOriginalExtension();
            $usuario->foto = $nom_foto;
            $file->move(public_path() . '/imgs/users/', $nom_foto);
        }
        $usuario->save();
        return response()->JSON([
            'sw' => true,
            'usuario' => $usuario,
            'msj' => 'Foto actualizada con éxito'
        ], 200);
    }

    public function destroy(User $usuario)
    {
        $antiguo = $usuario->foto;
        if ($antiguo != 'default.png') {
            \File::delete(public_path() . '/imgs/users/' . $antiguo);
        }
        $usuario->delete();
        return response()->JSON([
            'sw' => true,
            'msj' => 'El registro se eliminó correctamente'
        ], 200);
    }

    public function getPermisos(User $usuario)
    {
        $tipo = $usuario->tipo;
        return response()->JSON($this->permisos[$tipo]);
    }

    public function getInfoBox()
    {
        $tipo = Auth::user()->tipo;
        $array_infos = [];
        if (in_array('usuarios.index', $this->permisos[$tipo])) {
            $array_infos[] = [
                'label' => 'Usuarios',
                'cantidad' => count(User::where('id', '!=', 1)->get()),
                'color' => 'bg-info',
                'icon' => 'fas fa-users',
            ];
        }
        if (in_array('clientes.index', $this->permisos[$tipo])) {
            if (Auth::user()->tipo == 'GERENTE') {
                $array_infos[] = [
                    'label' => 'Clientes',
                    'cantidad' => count(Cliente::all()),
                    'color' => 'bg-success',
                    'icon' => 'fas fa-users',
                ];
            } else {
                $array_infos[] = [
                    'label' => 'Clientes',
                    'cantidad' => count(Cliente::where("sucursal_id", Auth::user()->sucursal_id)->get()),
                    'color' => 'bg-success',
                    'icon' => 'fas fa-users',
                ];
            }
        }
        if (in_array('empleados.index', $this->permisos[$tipo])) {
            $array_infos[] = [
                'label' => 'Empleados',
                'cantidad' => count(Empleado::all()),
                'color' => 'bg-primary',
                'icon' => 'fas fa-users',
            ];
        }
        if (in_array('maquinas.index', $this->permisos[$tipo])) {
            $array_infos[] = [
                'label' => 'Máquinas',
                'cantidad' => count(Maquina::all()),
                'color' => 'bg-warning',
                'icon' => 'fas fa-boxes',
            ];
        }

        if (Auth::user()->tipo == 'GERENTE') {
            Inscripcion::actualizaInscripciones();
        }

        if (Auth::user()->tipo == 'ENCARGADO DE RECEPCIÓN') {
            Inscripcion::actualizaInscripcionesPorSucursal(Auth::user()->sucursal_id);
        }

        return response()->JSON($array_infos);
    }

    public function userActual()
    {
        return response()->JSON(Auth::user());
    }

    public function getUsuario(User $usuario)
    {
        return response()->JSON($usuario);
    }
}
