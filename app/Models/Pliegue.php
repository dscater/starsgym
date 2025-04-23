<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pliegue extends Model
{
    use HasFactory;

    protected $fillable = [
        "evaluacion_id", "fecha", "bicipital1", "bicipital2", "bicipital3", "bicipital4", "tricipital1",
        "tricipital2", "tricipital3", "tricipital4", "subescapular1", "subescapular2", "subescapular3",
        "subescapular4", "axilar1", "axilar2", "axilar3", "axilar4", "pectoral1", "pectoral2",
        "pectoral3", "pectoral4", "abdominal1", "abdominal2", "abdominal3", "abdominal4", "supraliaco1",
        "supraliaco2", "supraliaco3", "supraliaco4", "muslo1", "muslo2", "muslo3", "muslo4", "pantorilla1",
        "pantorilla2", "pantorilla3", "pantorilla4", "resultado1", "resultado2", "resultado3", "resultado4",
    ];

    public function evaluacion()
    {
        return $this->belongsTo(EvaluacionFisica::class, 'evaluacion_id');
    }
}
