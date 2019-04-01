<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function(Blueprint $table)
        {
            $table->increments('id');
            $table->time('horaInicio')->nullable()->default(null);
            $table->time('horaFin')->nullable()->default(null);
            $table->date('fecha')->nullable()->default(null);
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
        Schema::dropIfExists('citas');
    }
}
