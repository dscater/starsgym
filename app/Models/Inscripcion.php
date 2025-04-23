<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $fillable = [
        "cliente_id",
        "plan_id",
        "sucursal_id",
        "disciplina",
        "fecha_inscripcion",
        "fecha_pivote",
        "conteo",
        "restante",
        "pausa",
        "fecha_fin",
        "codigo_rfid",
        "estado_cobro",
        "fecha_registro",
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public static function actualizaInscripciones()
    {
        $inscripciones = Inscripcion::where("estado", "!=", "CONCLUIDO")
            ->where("pausa", "!=", 1)->get();
        // $inscripciones = Inscripcion::where("pausa", "!=", 1)->get();
        $fecha_actual = date("Y-m-d");
        $fecha_hoy = new DateTime($fecha_actual);

        foreach ($inscripciones as $value) {
            $duracion = $value->plan->duracion;
            if ($value->fecha_fin < $fecha_actual) {
                $value->estado = 'CONCLUIDO';
                $value->pausa = 0;
                $value->conteo = $duracion;
                $value->restante = 0;
            } else {
                $fecha_pivote = new DateTime($value->fecha_pivote);
                $intervalo = $fecha_pivote->diff($fecha_hoy);
                $value->conteo = $intervalo->d;
                $value->restante = (int)$duracion - (int)$value->conteo;
            }
            $value->save();
        }

        $inscripciones_pausadas = Inscripcion::where("estado", "!=", "CONCLUIDO")
            ->where("pausa", 1)
            ->get();
        foreach ($inscripciones_pausadas as $value) {
            $fecha_pivote = new DateTime($fecha_actual);
            $value->fecha_pivote = $fecha_pivote;
            $sumar_restantes = $value->restante;
            $value->fecha_fin = date("Y-m-d", strtotime($fecha_actual . "+$sumar_restantes days"));
            $value->save();
        }

        return true;
    }

    public static function actualizaInscripcionesPorSucursal($id)
    {
        $inscripciones = Inscripcion::where("estado", "!=", "CONCLUIDO")
            ->where("sucursal_id", $id)
            ->where("pausa", "!=", 1)->get();
        // $inscripciones = Inscripcion::where("pausa", "!=", 1)->get();
        $fecha_actual = date("Y-m-d");
        $fecha_hoy = new DateTime($fecha_actual);

        foreach ($inscripciones as $value) {
            $duracion = $value->plan->duracion;
            if ($value->fecha_fin < $fecha_actual) {
                $value->estado = 'CONCLUIDO';
                $value->pausa = 0;
                $value->conteo = $duracion;
                $value->restante = 0;
            } else {
                $fecha_pivote = new DateTime($value->fecha_pivote);
                $intervalo = $fecha_pivote->diff($fecha_hoy);
                $value->conteo = $intervalo->d;
                $value->restante = (int)$duracion - (int)$value->conteo;
            }
            $value->save();
        }

        $inscripciones_pausadas = Inscripcion::where("estado", "!=", "CONCLUIDO")
            ->where("sucursal_id", $id)
            ->where("pausa", 1)
            ->get();
        foreach ($inscripciones_pausadas as $value) {
            $fecha_pivote = new DateTime($fecha_actual);
            $value->fecha_pivote = $fecha_pivote;
            $sumar_restantes = $value->restante;
            $value->fecha_fin = date("Y-m-d", strtotime($fecha_actual . "+$sumar_restantes days"));
            $value->save();
        }

        return true;
    }

    public static function actualizaPorInscripcion(Inscripcion $inscripcion)
    {
        $fecha_actual = date("Y-m-d");
        $fecha_hoy = new DateTime($fecha_actual);
        $duracion = $inscripcion->plan->duracion;

        if ($inscripcion->pausa == 0) {
            if ($inscripcion->fecha_fin < $fecha_actual) {
                $inscripcion->estado = 'CONCLUIDO';
                $inscripcion->pausa = 0;
                $inscripcion->conteo = $duracion;
                $inscripcion->restante = 0;
            } else {
                $fecha_pivote = new DateTime($inscripcion->fecha_pivote);
                $intervalo = $fecha_pivote->diff($fecha_hoy);
                $inscripcion->conteo = $intervalo->d;
                $inscripcion->restante = (int)$duracion - (int)$inscripcion->conteo;
            }
        } else {
            $fecha_pivote = new DateTime($fecha_actual);
            $inscripcion->fecha_pivote = $fecha_pivote;
            $sumar_restantes = $inscripcion->restante;
            $inscripcion->fecha_fin = date("Y-m-d", strtotime($fecha_actual . "+$sumar_restantes days"));
        }

        $inscripcion->save();
        return true;
    }
}
