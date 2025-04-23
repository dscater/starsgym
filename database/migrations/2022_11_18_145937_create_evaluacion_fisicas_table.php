<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionFisicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluacion_fisicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cliente_id");
            $table->unsignedBigInteger("sucursal_id");
            $table->string("talla")->nullable();
            $table->string("tipo_sangre")->nullable();
            $table->string("persona_referencia", 255)->nullable();
            $table->date("fecha")->nullable();
            $table->string("peso_inicial")->nullable();
            $table->text("patologias")->nullable();
            $table->text("obs_postura")->nullable();
            $table->text("recomendaciones")->nullable();
            $table->timestamps();

            $table->foreign("cliente_id")->on("clientes")->references("id");
            $table->foreign("sucursal_id")->on("sucursals")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluacion_fisicas');
    }
}
