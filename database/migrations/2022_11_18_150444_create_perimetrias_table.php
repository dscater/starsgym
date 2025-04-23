<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerimetriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perimetrias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("evaluacion_id");
            $table->date("fecha");
            $table->string("hombros1")->nullable();
            $table->string("hombros2")->nullable();
            $table->string("hombros3")->nullable();
            $table->string("hombros4")->nullable();
            $table->string("pecho1")->nullable();
            $table->string("pecho2")->nullable();
            $table->string("pecho3")->nullable();
            $table->string("pecho4")->nullable();
            $table->string("biceps_relajado1")->nullable();
            $table->string("biceps_relajado2")->nullable();
            $table->string("biceps_relajado3")->nullable();
            $table->string("biceps_relajado4")->nullable();
            $table->string("biceps_contraido1")->nullable();
            $table->string("biceps_contraido2")->nullable();
            $table->string("biceps_contraido3")->nullable();
            $table->string("biceps_contraido4")->nullable();
            $table->string("antebrazo1")->nullable();
            $table->string("antebrazo2")->nullable();
            $table->string("antebrazo3")->nullable();
            $table->string("antebrazo4")->nullable();
            $table->string("muneca1")->nullable();
            $table->string("muneca2")->nullable();
            $table->string("muneca3")->nullable();
            $table->string("muneca4")->nullable();
            $table->string("cintura1")->nullable();
            $table->string("cintura2")->nullable();
            $table->string("cintura3")->nullable();
            $table->string("cintura4")->nullable();
            $table->string("abdomen1")->nullable();
            $table->string("abdomen2")->nullable();
            $table->string("abdomen3")->nullable();
            $table->string("abdomen4")->nullable();
            $table->string("cadera1")->nullable();
            $table->string("cadera2")->nullable();
            $table->string("cadera3")->nullable();
            $table->string("cadera4")->nullable();
            $table->string("muslo1")->nullable();
            $table->string("muslo2")->nullable();
            $table->string("muslo3")->nullable();
            $table->string("muslo4")->nullable();
            $table->string("rodilla1")->nullable();
            $table->string("rodilla2")->nullable();
            $table->string("rodilla3")->nullable();
            $table->string("rodilla4")->nullable();
            $table->string("pantorilla1")->nullable();
            $table->string("pantorilla2")->nullable();
            $table->string("pantorilla3")->nullable();
            $table->string("pantorilla4")->nullable();
            $table->string("tobillo1")->nullable();
            $table->string("tobillo2")->nullable();
            $table->string("tobillo3")->nullable();
            $table->string("tobillo4")->nullable();
            $table->string("resultado1")->nullable();
            $table->string("resultado2")->nullable();
            $table->string("resultado3")->nullable();
            $table->string("resultado4")->nullable();
            $table->timestamps();

            $table->foreign("evaluacion_id")->on("evaluacion_fisicas")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perimetrias');
    }
}
