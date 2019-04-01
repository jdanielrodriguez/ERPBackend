<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeguimientosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimientos', function(Blueprint $table)
        {
            $table->increments('id'); 
            $table->string('llamada')->nullable()->default(null);
            $table->date('fecha')->nullable()->default(null);
            $table->integer('eseguido')->nullable()->default(0);
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
        Schema::dropIfExists('seguimientos');
    }
}
