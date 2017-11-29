<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComisionesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comisiones', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fechaini')->nullable()->default(null);
            $table->date('fechafin')->nullable()->default(null);
            $table->double('monto',5,2)->nullable()->default(null);
            $table->double('porcentaje',5,2)->nullable()->default(null);
            $table->double('total',7,2)->nullable()->default(null);
            $table->tinyInteger('estado')->nullable()->default(1);

            $table->integer('usuario')->nullable()->default(null);
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
        Schema::dropIfExists('comisiones');
    }
}
