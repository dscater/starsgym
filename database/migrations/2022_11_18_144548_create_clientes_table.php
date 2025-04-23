<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 155);
            $table->string("paterno", 155)->nullable();
            $table->string("materno", 155)->nullable();
            $table->string("ci");
            $table->string("ci_exp");
            $table->date("fecha_nacimiento");
            $table->integer("edad");
            $table->string("genero");
            $table->string("dir", 255)->nullable();
            $table->string("fono", 255)->nullable();
            $table->string("fono2", 255)->nullable();
            $table->string("correo", 255)->nullable();
            $table->string("foto", 255)->nullable();
            $table->string("declaracion_jurada", 255)->nullable();
            $table->unsignedBigInteger("sucursal_id");
            $table->date("fecha_registro");
            $table->timestamps();

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
        Schema::dropIfExists('clientes');
    }
}
