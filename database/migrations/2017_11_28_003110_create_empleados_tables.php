<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('direccion')->nullable()->default(null);
            $table->string('telefono')->nullable()->default(null);
            $table->string('celular')->nullable();
            $table->double('sueldo')->nullable()->default(0);
            $table->tinyInteger('estado')->nullable()->default(1);

            $table->integer('puesto')->unsigned()->nullable()->default(null);
            $table->foreign('puesto')->references('id')->on('puestos')->onDelete('cascade');
            
            $table->integer('sucursal')->unsigned()->nullable()->default(null);
            $table->foreign('sucursal')->references('id')->on('sucursales')->onDelete('cascade');
            
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
        Schema::dropIfExists('empleados');
    }
}
