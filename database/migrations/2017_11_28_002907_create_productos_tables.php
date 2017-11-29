<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion')->nullable()->default(null);
            $table->string('nombre')->nullable();
            $table->string('codigo')->nullable();
            $table->string('marcaDes')->nullable()->default(null);
            $table->tinyInteger('tipo')->nullable()->default(null);
            $table->tinyInteger('estado')->nullable()->default(1);

            $table->integer('marca')->nullable()->default(null);
            $table->foreign('marca')->references('id')->on('marcas')->onDelete('cascade');
            
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
        Schema::dropIfExists('productos');
    }
}
