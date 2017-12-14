<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentascobrarTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentascobrar', function (Blueprint $table) {
            $table->increments('id');
            $table->double('creditoDado',5,2)->nullable()->default(null);
            $table->double('total',5,2)->nullable()->default(null);
            $table->timestamp('fecha')->useCurrent();
            $table->timestamp('fechaAnt')->nullable()->default(null);
            $table->integer('plazo')->nullable()->default(null);
            $table->integer('tipoPlazo')->nullable()->default(null);
            $table->tinyInteger('estado')->nullable()->default(1);

            $table->integer('venta')->unsigned()->nullable()->default(null);
            $table->foreign('venta')->references('id')->on('ventas')->onDelete('cascade');

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
        Schema::dropIfExists('cuentascobrar');
    }
}
