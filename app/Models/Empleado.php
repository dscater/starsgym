<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        "nombre", "paterno", "materno", "ci",
        "ci_exp", "dir", "fono", "fono_referencia",
        "correo", "fecha_inicio", "cargo", "salario",
        "horario", "foto", "sucursal_id",
        "fecha_registro",
    ];

    protected $appends = ['full_name', 'full_ci', 'path_image'];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
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
            return asset('imgs/empleados/' . $this->foto);
        }
        return asset('imgs/empleados/default.png');
    }
}
