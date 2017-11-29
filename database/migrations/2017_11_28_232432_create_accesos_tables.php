<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccesosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesos', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('agregar')->default(0);
            $table->tinyInteger('modificar')->default(0);
            $table->tinyInteger('mostrar')->default(0);
            $table->tinyInteger('eliminar')->default(0);
            
            $table->integer('usuario')->unsigned();
            $table->foreign('usuario')->references('id')->on('usuarios')->onDelete('cascade');
            $table->integer('modulo')->unsigned();
            $table->foreign('modulo')->references('id')->on('modulos')->onDelete('cascade');
            
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
        Schema::dropIfExists('accesos');
    }
}
