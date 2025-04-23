<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    use HasFactory;
    protected $fillable = [
        "codigo", "nombre", "categoria_id", "descripcion", "sucursal_id",
        "fecha_incorporacion", "cantidad", "foto", "estado", "fecha_registro",
    ];

    protected $appends = ['path_image'];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // APPENDS
    public function getPathImageAttribute()
    {
        if ($this->foto && trim($this->foto) != "") {
            return asset('imgs/maquinas/' . $this->foto);
        }
        return asset('imgs/maquinas/default.png');
    }
}
