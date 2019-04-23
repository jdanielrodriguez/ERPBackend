<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('placa')->nullable()->default(null);
            $table->string('modelo')->nullable()->default(null);
            $table->string('serie')->nullable()->default(null);
            $table->string('entrega')->nullable()->default(null);
            $table->string('comentario')->nullable()->default(null);
            $table->date('fechaMantenimiento')->nullable()->default(null);
            $table->date('fechaSiguienteMantenimiento')->nullable()->default(null);
            $table->integer('mantenimiento')->nullable()->default(0);
            $table->tinyInteger('estado')->nullable()->default(1);       

            $table->integer('cliente')->unsigned()->nullable()->default(null);
            $table->foreign('cliente')->references('id')->on('clientes')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
}
