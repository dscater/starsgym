<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phpml\Regression\LeastSquares;
use App\Models\Inscripcion;
use Carbon\Carbon;

class NotificacionController extends Controller
{
    public function index()
    {
        // entrenar el modelo
        $modelo = $this->entrenarModelo();

        //generar las notificaciones
        $this->generarNotificaciones($modelo);

        return response()->JSON(true);
    }

    /**
     * Entrenar el modelo
     *
     * @return void
     */
    private function entrenarModelo()
    {
        $dataset = [];
        $targets = [];

        // Obtener las inscripciones
        $inscripciones = Inscripcion::all();
        foreach ($inscripciones as $inscripcion) {
            $dias_restantes = Carbon::now()->diffInDays($inscripcion->fecha_fin, false);
            $dataset[] = [$dias_restantes];
            $targets[] = $dias_restantes == 0 ? 1 : 0;
        }

        // Entrenar el modelo
        $model = new LeastSquares();
        $model->train($dataset, $targets);

        // retornar el modelo
        return $model;
    }

    /**
     * Generar las notificaciones
     *
     * @param [type] $modelo
     * @return void
     */
    private function generarNotificaciones($modelo)
    {
        $model = new LeastSquares();
        $model->train($modelo['dataset'], $modelo['targets']);

        $inscripciones = Inscripcion::all();
        foreach ($inscripciones as $inscripcion) {
            $dias_restantes = Carbon::now()->diffInDays($inscripcion->fecha_fin, false);
            $probabilidad = $model->predict([$dias_restantes]);

            if ($probabilidad < 0.5) {
                $notificacion = Notificacion::firstOrCreate([
                    "descripcion" => "LA INSCRIPCIÓN DEL CLIENTE " . $inscripcion->cliente->full_name . " FINALIZA HOY",
                ]);

                NotificacionUser::firstOrCreate([
                    'user_id' => $inscripcion->usuario_id,
                    'notificacion_id' => $notificacion->id
                ]);
            }
        }
    }
}
