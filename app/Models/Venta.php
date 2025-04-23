<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        "sucursal_id",
        "cliente_id",
        "total",
        "qr",
        "fecha",
        "fecha_registro",
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function detalle_ventas()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }
}
