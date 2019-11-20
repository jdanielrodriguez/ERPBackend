<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->double('total',50,2)->nullable()->default(null);
            $table->date('fecha')->nullable()->default(null);
            $table->string('comprobante')->nullable()->default(1);
            $table->tinyInteger('taller')->nullable()->default(0);
            $table->tinyInteger('estado')->nullable()->default(1);

            $table->integer('tipo')->unsigned()->nullable()->default(null);
            $table->foreign('tipo')->references('id')->on('tiposventa')->onDelete('cascade');

            $table->integer('cliente')->unsigned()->nullable()->default(null);
            $table->foreign('cliente')->references('id')->on('clientes')->onDelete('cascade');

            $table->integer('usuario')->unsigned()->nullable()->default(null);
            $table->foreign('usuario')->references('id')->on('usuarios')->onDelete('cascade');

            $table->integer('sucursal')->unsigned()->nullable()->default(null);
            $table->foreign('sucursal')->references('id')->on('sucursales')->onDelete('cascade');

            $table->integer('vehiculo')->unsigned()->nullable()->default(null);
            $table->foreign('vehiculo')->references('id')->on('vehiculos')->onDelete('cascade');

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
        Schema::dropIfExists('ventas');
    }
}
