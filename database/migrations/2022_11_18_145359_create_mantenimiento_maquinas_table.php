<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantenimientoMaquinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimiento_maquinas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sucursal_id");
            $table->unsignedBigInteger("maquina_id");
            $table->date("fecha_mantenimiento")->nullable();
            $table->text("descripcion")->nullable();
            $table->date("fecha_proximo")->nullable();
            $table->date("fecha_registro");
            $table->timestamps();
            $table->foreign("sucursal_id")->on("sucursals")->references("id");
            $table->foreign("maquina_id")->on("maquinas")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mantenimiento_maquinas');
    }
}
