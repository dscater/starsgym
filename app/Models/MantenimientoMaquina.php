<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MantenimientoMaquina extends Model
{
    use HasFactory;

    protected $fillable = [
        "sucursal_id", "maquina_id", "fecha_mantenimiento", "descripcion", "fecha_proximo", "fecha_registro"
    ];

    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'maquina_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }
}
