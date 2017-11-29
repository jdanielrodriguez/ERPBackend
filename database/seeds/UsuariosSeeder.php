<?php

use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'username'         => "Bicicasa",
            'password'         => "81584879",
            'email'            => "Quetzaltenango",
            'privileges'       => "78954884",
            'rol'              => "2215487",
            'empleado'         => "2215487",
            'sucursal'         => "2215487",
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);
    }
}
