<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imcs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("evaluacion_id");
            $table->string("peso1")->nullable();
            $table->string("peso2")->nullable();
            $table->string("peso3")->nullable();
            $table->string("peso4")->nullable();
            $table->string("imc1")->nullable();
            $table->string("imc2")->nullable();
            $table->string("imc3")->nullable();
            $table->string("imc4")->nullable();
            $table->string("glicemia1")->nullable();
            $table->string("glicemia2")->nullable();
            $table->string("glicemia3")->nullable();
            $table->string("glicemia4")->nullable();
            $table->string("rpm1")->nullable();
            $table->string("rpm2")->nullable();
            $table->string("rpm3")->nullable();
            $table->string("rpm4")->nullable();
            $table->string("lpm1")->nullable();
            $table->string("lpm2")->nullable();
            $table->string("lpm3")->nullable();
            $table->string("lpm4")->nullable();
            $table->string("oxigeno1")->nullable();
            $table->string("oxigeno2")->nullable();
            $table->string("oxigeno3")->nullable();
            $table->string("oxigeno4")->nullable();
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
        Schema::dropIfExists('imcs');
    }
}
