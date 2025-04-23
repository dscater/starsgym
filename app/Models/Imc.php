<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imc extends Model
{
    use HasFactory;

    protected $fillable = [
        "evaluacion_id", "peso1", "peso2", "peso3", "peso4",
        "imc1", "imc2", "imc3", "imc4", "glicemia1", "glicemia2",
        "glicemia3", "glicemia4", "rpm1", "rpm2", "rpm3",
        "rpm4", "lpm1", "lpm2", "lpm3", "lpm4", "oxigeno1",
        "oxigeno2", "oxigeno3", "oxigeno4",
    ];

    public function evaluacion()
    {
        return $this->belongsTo(EvaluacionFisica::class, 'evaluacion_id');
    }
}
