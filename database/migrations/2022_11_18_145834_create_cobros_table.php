<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cliente_id");
            $table->unsignedBigInteger("inscripcion_id");
            $table->unsignedBigInteger("sucursal_id");
            $table->date("fecha_cobro");
            $table->date("fecha_registro");
            $table->timestamps();

            $table->foreign("cliente_id")->on("clientes")->references("id");
            $table->foreign("inscripcion_id")->on("inscripcions")->references("id");
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
        Schema::dropIfExists('cobros');
    }
}
