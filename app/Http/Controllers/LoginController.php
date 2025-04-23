<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $usuario = $request->usuario;
        $password = $request->password;
        $res = Auth::attempt(['codigo' => $usuario, 'password' => $password]);
        if ($res) {
            $this->initNoti();

            return response()->JSON([
                'user' => Auth::user(),
            ], 200);
        }

        return response()->JSON([], 401);
    }

    public function logout()
    {
        Auth::logout();
        return response()->JSON(['code' => 204], 204);
    }

    private function initNoti()
    {
        $actual = date("Y-m-d");
        $hora = date("H:i");
        $registros = Inscripcion::where("fecha_fin", $actual)->get();
        $users = User::all();
        foreach ($registros as $item) {
            $existe = Notificacion::where("registro", $item->id)
                ->where("fecha", $actual)->get()->first();

            if (!$existe) {
                $notificacion = Notificacion::create([
                    "registro" => $item->id,
                    "tipo" => "INSCRIPCION",
                    "descripcion" => "LA INSCRIPCIÓN DEL CLIENTE " . $item->cliente->full_name . " FINALIZA HOY",
                    "fecha" => $actual,
                    "hora" => $hora,
                ]);
                foreach ($users as $user) {
                    $user->notificacion_user()->create([
                        "notificacion_id" => $notificacion->id,
                    ]);
                }
            }
        }
    }
}
