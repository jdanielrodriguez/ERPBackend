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
            $table->double('total',5,2)->nullable()->default(null);
            $table->timestamp('fecha')->useCurrent();
            $table->string('comprobante')->nullable()->default(1);
            $table->tinyInteger('estado')->nullable()->default(2);

            $table->integer('tipo')->nullable()->default(null);
            $table->foreign('tipo')->references('id')->on('tiposventa')->onDelete('cascade');

            $table->integer('cliente')->nullable()->default(null);
            $table->foreign('cliente')->references('id')->on('clientes')->onDelete('cascade');

            $table->integer('usuario')->nullable()->default(null);
            $table->foreign('usuario')->references('id')->on('usuarios')->onDelete('cascade');

            $table->integer('sucursal')->nullable()->default(null);
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
        Schema::dropIfExists('ventas');
    }
}
