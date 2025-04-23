<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        "nombre",
        "categoria_id",
        "descripcion",
        "precio",
        "sucursal_id",
        "foto",
        "stock_actual",
        "ingresos",
        "salidas",
        "fecha_registro",
    ];
    protected $appends = ['path_image'];
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function detalle_ventas()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id');
    }

    // ***************************************************** //
    public function getPathImageAttribute()
    {
        if ($this->foto && trim($this->foto) != "") {
            return asset('imgs/productos/' . $this->foto);
        }
        return asset('imgs/productos/default.png');
    }
}
