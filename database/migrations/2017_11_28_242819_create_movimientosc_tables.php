<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientoscTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientosc', function (Blueprint $table) {
            $table->increments('id');
            $table->double('credito',50,2)->nullable()->default(null);
            $table->double('abono',15,2)->nullable()->default(null);
            $table->double('saldo',70,2)->nullable()->default(null);
            $table->timestamp('fecha')->useCurrent();
            $table->string('descripcion')->nullable()->default(null);
            $table->tinyInteger('estado')->nullable()->default(1);

            $table->integer('cuentacobrar')->unsigned()->nullable()->default(null);
            $table->foreign('cuentacobrar')->references('id')->on('cuentascobrar')->onDelete('cascade');

            $table->integer('usuario')->unsigned()->nullable()->default(null);
            $table->foreign('usuario')->references('id')->on('usuarios')->onDelete('cascade');

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
        Schema::dropIfExists('movimientosc');
    }
}
