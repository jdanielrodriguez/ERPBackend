<?php

use Illuminate\Database\Seeder;

class TiposVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tiposventa')->insert([
            'descripcion'      => "Contado",
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('tiposventa')->insert([
            'descripcion'      => "Credito",
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('tiposventa')->insert([
            'descripcion'      => "Donacion",
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('tiposdetalleventas')->insert([
            'descripcion'      => "Contado",
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('tiposdetalleventas')->insert([
            'descripcion'      => "Credito",
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('tiposdetalleventas')->insert([
            'descripcion'      => "Donacion",
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);
    }
}
