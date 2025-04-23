<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perimetria extends Model
{
    use HasFactory;

    protected $fillable = [
        "evaluacion_id", "fecha", "hombros1", "hombros2", "hombros3", "hombros4", "pecho1", "pecho2", "pecho3",
        "pecho4", "biceps_relajado1", "biceps_relajado2", "biceps_relajado3", "biceps_relajado4",
        "biceps_contraido1", "biceps_contraido2", "biceps_contraido3", "biceps_contraido4", "antebrazo1",
        "antebrazo2", "antebrazo3", "antebrazo4", "muneca1", "muneca2", "muneca3", "muneca4", "cintura1",
        "cintura2", "cintura3", "cintura4", "abdomen1", "abdomen2", "abdomen3", "abdomen4", "cadera1", "cadera2",
        "cadera3", "cadera4", "muslo1", "muslo2", "muslo3", "muslo4", "rodilla1", "rodilla2", "rodilla3", "rodilla4",
        "pantorilla1", "pantorilla2", "pantorilla3", "pantorilla4", "tobillo1", "tobillo2", "tobillo3",
        "tobillo4", "resultado1", "resultado2", "resultado3", "resultado4",
    ];

    public function evaluacion()
    {
        return $this->belongsTo(EvaluacionFisica::class, 'evaluacion_id');
    }
}
