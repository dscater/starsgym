<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscripcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cliente_id");
            $table->unsignedBigInteger("plan_id");
            $table->string("disciplina", 255);
            $table->unsignedBigInteger("sucursal_id");
            $table->date("fecha_inscripcion");
            $table->date("fecha_pivote")->nullable();
            $table->integer("conteo");
            $table->integer("restante");
            $table->integer("pausa");
            $table->date("fecha_pausa")->nullable();
            $table->date("fecha_fin");
            $table->string("codigo_rfid")->unique();
            $table->string("estado", 155);
            $table->string("estado_cobro", 155);
            $table->text("justificacion")->nullable();
            $table->date("fecha_registro");
            $table->timestamps();

            $table->foreign("cliente_id")->on("clientes")->references("id");
            $table->foreign("plan_id")->on("plans")->references("id");
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
        Schema::dropIfExists('inscripcions');
    }
}
