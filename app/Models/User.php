<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario',
        'codigo',
        'password',
        'correo',
        'tipo',
        'foto',
        'sucursal_id',
        'fecha_registro',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    protected $appends = ['full_name', 'full_ci', 'path_image'];
    protected $with = ['sucursal'];

    public static function getNombreUsuario($nom, $apep)
    {
        //determinando el nombre de usuario inicial del 1er_nombre+apep+tipoUser
        $nombre_user = substr(mb_strtoupper($nom), 0, 1); //inicial 1er_nombre
        $nombre_user .= mb_strtoupper($apep);

        return $nombre_user;
    }
    public function getFullNameAttribute()
    {
        return $this->usuario;
    }

    public function getFullCiAttribute()
    {
        return $this->ci . ' ' . $this->ci_exp;
    }

    public function getPathImageAttribute()
    {
        if ($this->foto && trim($this->foto) != "") {
            return asset('imgs/users/' . $this->foto);
        }
        return asset('imgs/users/default.png');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function notificacion_user()
    {
       return $this->hasMany(NotificacionUser::class, 'user_id');
    }
}
