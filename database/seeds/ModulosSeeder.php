<?php

use Illuminate\Database\Seeder;

class ModulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modulos')->insert([
            'nombre'           => "Inicio",
            'dir'              => "../app/img/inicio.png",
            'refId'            => "inicio",
            'tipo'             => 0,
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Usuarios",
            'dir'              => "../app/img/usuariotab.png",
            'refId'            => "usuario",
            'tipo'             => 0,
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Compras",
            'dir'              => "../app/img/carro-de-la-compra.png",
            'refId'            => "compras",
            'tipo'             => 0,
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);
        
        DB::table('modulos')->insert([
            'nombre'           => "Ventas",
            'dir'              => "../app/img/diagrama.png",
            'refId'            => "ventas",
            'tipo'             => 0,
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Cuentas",
            'dir'              => "../app/img/etiqueta-del-precio.png",
            'refId'            => "cuentas",
            'tipo'             => 0,
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Estadistica",
            'dir'              => "../app/img/reparacion-mecanismo.png",
            'refId'            => "estadistica",
            'tipo'             => 1,
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Inventario",
            'dir'              => "../app/img/notas.png",
            'refId'            => "inventario",
            'tipo'             => 0,
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Pagos",
            'dir'              => "../app/img/pagos.png",
            'refId'            => "pagos",
            'tipo'             => 1,
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Clientes",
            'dir'              => "../app/img/clientes.png",
            'refId'            => "clientes1",
            'tipo'             => 1,
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Proveedores",
            'dir'              => "../app/img/proveedores.png",
            'refId'            => "proveedores1",
            'tipo'             => 1,
            'estado'           => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);
    }
}
