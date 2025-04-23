<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaquinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquinas', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 255);
            $table->unsignedBigInteger("categoria_id");
            $table->text("descripcion");
            $table->unsignedBigInteger("sucursal_id");
            $table->date("fecha_incorporacion")->nullable();
            $table->integer("cantidad")->nullable()->default(0);
            $table->string("foto", 255)->nullable();
            $table->date("fecha_registro");
            $table->timestamps();

            $table->foreign("categoria_id")->on("categorias")->references("id");
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
        Schema::dropIfExists('maquinas');
    }
}
