<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sucursal_id");
            $table->unsignedBigInteger("producto_id");
            $table->integer("cantidad");
            $table->date("fecha_ingreso");
            $table->date("fecha_registro");
            $table->timestamps();

            $table->foreign("sucursal_id")->on("sucursals")->references("id");
            $table->foreign("producto_id")->on("productos")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingreso_productos');
    }
}
