<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        "nombre", "paterno", "materno", "ci", "ci_exp",
        "fecha_nacimiento", "edad", "genero", "dir",
        "fono", "fono2", "correo", "foto", "declaracion_jurada", "sucursal_id",
        "fecha_registro",
    ];
    protected $appends = ['full_name', 'full_ci', 'path_image'];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function inscripcions()
    {
        return $this->hasMany(Inscripcion::class, 'cliente_id');
    }

    // APPENDS
    public function getFullNameAttribute()
    {
        return $this->nombre . ' ' . ($this->paterno != NULL && $this->paterno != '' ? ' ' . $this->paterno : '') . ($this->materno != NULL && $this->materno != '' ? ' ' . $this->materno : '');
    }

    public function getFullCiAttribute()
    {
        return $this->ci . ' ' . $this->ci_exp;
    }

    public function getPathImageAttribute()
    {
        if ($this->foto && trim($this->foto) != "") {
            return asset('imgs/clientes/' . $this->foto);
        }
        return asset('imgs/clientes/default.png');
    }
}
