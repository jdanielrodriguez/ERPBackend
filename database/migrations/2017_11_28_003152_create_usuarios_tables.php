<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('password');
            $table->string('email');
            $table->string('picture')->nullable()->default('https://d30y9cdsu7xlg0.cloudfront.net/png/17241-200.png');
            $table->integer('privileges')->nullable()->default(1);
            $table->tinyInteger('estado')->default(1);

            $table->integer('rol')->unsigned()->nullable()->default(null);
            $table->foreign('rol')->references('id')->on('roles')->onDelete('cascade');
            $table->integer('empleado')->unsigned()->nullable()->default(null);
            $table->foreign('empleado')->references('id')->on('empleados')->onDelete('cascade');
            $table->integer('sucursal')->unsigned()->nullable()->default(null);
            $table->foreign('sucursal')->references('id')->on('sucursales')->onDelete('cascade');

            $table->rememberToken();
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
        Schema::dropIfExists('usuarios');
    }
}
