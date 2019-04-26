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
            'nombre'           => "Dashboard",
            'dir'              => "../app/img/inicio.png",
            'refId'            => "inicio",
            'icono'            => "tachometer",
            'link'             => "dashboard",
            'tipo'             => 0,
            'estado'           => 1,
            'orden'            => 1,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Sucursales",
            'dir'              => "../app/img/usuariotab.png",
            'refId'            => "sucursales",
            'icono'            => "sitemap",
            'link'             => "sucursales",
            'tipo'             => 0,
            'estado'           => 1,
            'orden'            => 2,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Usuarios",
            'dir'              => "../app/img/usuariotab.png",
            'refId'            => "usuario",
            'icono'            => "users",
            'link'             => "usuarios",
            'tipo'             => 0,
            'estado'           => 1,
            'orden'            => 3,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Empleados",
            'dir'              => "../app/img/usuariotab.png",
            'refId'            => "usuario",
            'icono'            => "user",
            'link'             => "empleados",
            'tipo'             => 0,
            'estado'           => 1,
            'orden'            => 3,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Compras",
            'dir'              => "../app/img/carro-de-la-compra.png",
            'refId'            => "compras",
            'icono'            => "shopping-cart",
            'link'             => "compras",
            'tipo'             => 0,
            'estado'           => 1,
            'orden'            => 4,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);
        
        DB::table('modulos')->insert([
            'nombre'           => "Ventas",
            'dir'              => "../app/img/diagrama.png",
            'refId'            => "ventas",
            'icono'            => "tags",
            'link'             => "ventas",
            'tipo'             => 0,
            'estado'           => 1,
            'orden'            => 5,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);
        
        DB::table('modulos')->insert([
            'nombre'           => "Taller",
            'dir'              => "../app/img/diagrama.png",
            'refId'            => "taller",
            'icono'            => "gear",
            'link'             => "taller",
            'tipo'             => 0,
            'estado'           => 1,
            'orden'            => 6,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Cuentas",
            'dir'              => "../app/img/etiqueta-del-precio.png",
            'refId'            => "cuentas",
            'icono'            => "cogs",
            'link'             => "cuentas-cobrar",
            'tipo'             => 0,
            'estado'           => 1,
            'orden'            => 6,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Estadistica",
            'dir'              => "../app/img/reparacion-mecanismo.png",
            'refId'            => "estadistica",
            'icono'            => "list-alt",
            'link'             => "estadistica",
            'tipo'             => 1,
            'estado'           => 1,
            'orden'            => 7,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Inventario",
            'dir'              => "../app/img/notas.png",
            'refId'            => "inventario",
            'icono'            => "bars",
            'link'             => "inventario",
            'tipo'             => 0,
            'estado'           => 1,
            'orden'            => 8,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Pagos",
            'dir'              => "../app/img/pagos.png",
            'refId'            => "pagos",
            'icono'            => "credit-card",
            'link'             => "pagos",
            'tipo'             => 1,
            'estado'           => 1,
            'orden'            => 9,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Clientes",
            'dir'              => "../app/img/clientes.png",
            'refId'            => "clientes1",
            'icono'            => "ticket",
            'link'             => "clientes",
            'tipo'             => 1,
            'estado'           => 1,
            'orden'            => 10,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Proveedores",
            'dir'              => "../app/img/proveedores.png",
            'refId'            => "proveedores1",
            'icono'            => "truck",
            'link'             => "proveedores",
            'tipo'             => 1,
            'estado'           => 1,
            'orden'            => 11,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Contabilidad",
            'dir'              => "../app/img/reparacion-mecanismo.png",
            'refId'            => "conta",
            'icono'            => "fa fa-bar-chart-o",
            'link'             => "contabilidad/diario",
            'tipo'             => 0,
            'estado'           => 1,
            'orden'            => 12,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);

        DB::table('modulos')->insert([
            'nombre'           => "Llamadas",
            'dir'              => "../app/img/phone.png",
            'refId'            => "conta",
            'icono'            => "phone",
            'link'             => "llamadas",
            'tipo'             => 0,
            'estado'           => 1,
            'orden'            => 13,
            'deleted_at'       => null,
            'created_at'       => date('Y-m-d H:m:s'),
            'updated_at'       => date('Y-m-d H:m:s')
        ]);
    }
}
