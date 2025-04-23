<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlieguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pliegues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("evaluacion_id");
            $table->date("fecha")->nullable();
            $table->string("bicipital1")->nullable();
            $table->string("bicipital2")->nullable();
            $table->string("bicipital3")->nullable();
            $table->string("bicipital4")->nullable();
            $table->string("tricipital1")->nullable();
            $table->string("tricipital2")->nullable();
            $table->string("tricipital3")->nullable();
            $table->string("tricipital4")->nullable();
            $table->string("subescapular1")->nullable();
            $table->string("subescapular2")->nullable();
            $table->string("subescapular3")->nullable();
            $table->string("subescapular4")->nullable();
            $table->string("axilar1")->nullable();
            $table->string("axilar2")->nullable();
            $table->string("axilar3")->nullable();
            $table->string("axilar4")->nullable();
            $table->string("pectoral1")->nullable();
            $table->string("pectoral2")->nullable();
            $table->string("pectoral3")->nullable();
            $table->string("pectoral4")->nullable();
            $table->string("abdominal1")->nullable();
            $table->string("abdominal2")->nullable();
            $table->string("abdominal3")->nullable();
            $table->string("abdominal4")->nullable();
            $table->string("supraliaco1")->nullable();
            $table->string("supraliaco2")->nullable();
            $table->string("supraliaco3")->nullable();
            $table->string("supraliaco4")->nullable();
            $table->string("muslo1")->nullable();
            $table->string("muslo2")->nullable();
            $table->string("muslo3")->nullable();
            $table->string("muslo4")->nullable();
            $table->string("pantorilla1")->nullable();
            $table->string("pantorilla2")->nullable();
            $table->string("pantorilla3")->nullable();
            $table->string("pantorilla4")->nullable();
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
        Schema::dropIfExists('pliegues');
    }
}
