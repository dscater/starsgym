<?php

namespace App\Http\Controllers;

use App\Models\NotificacionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionUserController extends Controller
{
    public function index(Request $request)
    {
        $ultimo = 0;
        if (isset($request->ultimo)) {
            $ultimo = $request->ultimo;
        }
        $notificacion_users = NotificacionUser::with(["notificacion"])->where("user_id", Auth::user()->id);

        if (isset($request->navBar) && $request->navBar) {
            $notificacion_users->where("visto", 0);
        }

        $notificacion_users = $notificacion_users->orderBy("id", "desc")->get();
        if (count($notificacion_users) > 0) {
            $ultimo = $notificacion_users[0]->id;
        }

        return response()->JSON([
            "ultimo" => $ultimo,
            "notificacion_users" => $notificacion_users,
        ]);
    }
    public function show(NotificacionUser $notificacion_user)
    {
        $notificacion_user->visto = 1;
        $notificacion_user->save();

        $notificacion_user = $notificacion_user->load(["notificacion"]);

        return response()->JSON([
            "notificacion_user" => $notificacion_user
        ]);
    }
}
