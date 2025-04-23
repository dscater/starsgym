<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        "sucursal_id",
        "producto_id",
        "cantidad",
        "fecha_ingreso",
        "fecha_vencimiento",
        "fecha_registro",
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
