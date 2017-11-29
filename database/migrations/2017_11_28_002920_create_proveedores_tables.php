<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable()->default(null);
            $table->string('nit');

            $table->integer('municipio')->unsigned()->nullable()->default(null);
            $table->foreign('municipio')->references('id')->on('municipios')->onDelete('cascade');
            $table->integer('departamento')->unsigned()->nullable()->default(null);
            $table->foreign('departamento')->references('id')->on('departamentos')->onDelete('cascade');
            $table->integer('pais')->unsigned()->nullable()->default(null);
            $table->foreign('pais')->references('id')->on('paises')->onDelete('cascade');
            
            $table->string('direccion')->nullable()->default(null);
            $table->string('telefono')->nullable()->default(null);
            $table->string('cuenta')->nullable()->default(null);
            $table->tinyInteger('estado')->nullable()->default(1);
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
        Schema::dropIfExists('proveedores');
    }
}
