<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 155);
            $table->string("paterno", 155)->nullable();
            $table->string("materno", 155)->nullable();
            $table->string("ci");
            $table->string("ci_exp");
            $table->string("dir", 255)->nullable();
            $table->string("fono", 255)->nullable();
            $table->string("fono_referencia", 255)->nullable();
            $table->string("correo", 255)->nullable();
            $table->date("fecha_inicio");
            $table->string("cargo", 255)->nullable();
            $table->decimal("salario", 24, 2)->nullable();
            $table->string("horario", 255)->nullable();
            $table->string("foto", 255)->nullable();
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
        Schema::dropIfExists('empleados');
    }
}
