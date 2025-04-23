<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionFisica extends Model
{
    use HasFactory;

    protected $fillable = [
        "cliente_id",
        "sucursal_id",
        "talla",
        "tipo_sangre",
        "persona_referencia",
        "fecha",
        "peso_inicial",
        "patologias",
        "obs_postura",
        "recomendaciones",
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function pliegues()
    {
        return $this->hasOne(Pliegue::class, 'evaluacion_id');
    }

    public function perimetrias()
    {
        return $this->hasOne(Perimetria::class, 'evaluacion_id');
    }

    public function imcs()
    {
        return $this->hasOne(Imc::class, 'evaluacion_id');
    }
}
