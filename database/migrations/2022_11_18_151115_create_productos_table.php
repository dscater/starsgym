<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 255)->nullable();
            $table->unsignedBigInteger("categoria_id");
            $table->text("descripcion")->nullable();
            $table->decimal("precio", 24, 2);
            $table->unsignedBigInteger("sucursal_id");
            $table->string("foto", 255)->nullable();
            $table->integer("stock_actual");
            $table->integer("ingresos");
            $table->integer("salidas");
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
        Schema::dropIfExists('productos');
    }
}
