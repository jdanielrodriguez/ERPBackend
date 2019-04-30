<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('accesos', 'AccesosController');
Route::resource('clientes', 'ClientesController');
Route::resource('comisiones', 'ComisionesController');
Route::resource('compras', 'ComprasController');
Route::resource('comprasdetalle', 'ComprasDetalleController');
Route::resource('correos', 'CorreosController');
Route::resource('cuentascobrar', 'CuentasCobrarController');
Route::resource('cuentaspagar', 'CuentasPagarController');
Route::resource('departamentos', 'DepartamentosController');
Route::resource('empleados', 'EmpleadosController');
Route::resource('gastos', 'GastosController');
Route::resource('inventario', 'InventarioController');
Route::resource('marcas', 'MarcasController');
Route::resource('modulos', 'ModulosController');
Route::resource('movimientosc', 'MovimientosCController');
Route::resource('movimientosp', 'MovimientosPController');
Route::resource('municipios', 'MunicipiosController');
Route::resource('paises', 'PaisesController');
Route::resource('productos', 'ProductosController');
Route::resource('proveedores', 'ProveedoresController');
Route::resource('puestos', 'PuestosController');
Route::resource('roles', 'RolesController');
Route::resource('sucursales', 'SucursalesController');
Route::resource('sueldos', 'SueldosController');
Route::resource('tiposcompra', 'TiposCompraController');
Route::resource('tiposproducto', 'TiposProductoController');
Route::resource('tiposventa', 'TiposVentaController');
Route::resource('tiposdetallecompras', 'TiposDetalleComprasController');
Route::resource('tiposdetalleventas', 'TiposDetalleVentasController');
Route::resource('usuarios', 'UsuariosController');
Route::resource('ventas', 'VentasController');
Route::resource('ventasdetalle', 'VentasDetalleController');
Route::resource('vehiculos', 'VehiculosController');

Route::get('usuarios/{id}/vehiculos', 'VehiculosController@getThisByClient');

Route::post('usuarios/{id}/upload/avatar', 'UsuariosController@uploadAvatar');
Route::post('usuarios/{id}/changepassword', 'UsuariosController@changePassword');
Route::post('usuarios/password/reset', 'UsuariosController@recoveryPassword');

Route::get('usuarios/{id}/modulos', 'AccesosController@getAccesos');
Route::get('usuarios/{id}/modulos/{id2}', 'AccesosController@getAcceso');
Route::get('anuladas/compras', 'ComprasController@anuladas');
Route::get('anuladas/ventas', 'VentasController@anuladas');
Route::get('buscar/proveedores', 'ProveedoresController@find');
Route::get('buscar/clientes', 'ClientesController@find');
Route::get('pagadas/cuentaspagar', 'CuentasPagarController@pagadas');
Route::get('pagadas/cuentascobrar', 'CuentasCobrarController@pagadas');
Route::get('existencia/productos', 'ProductosController@existencia');
Route::get('admin/inventario', 'InventarioController@admin');
Route::get('comprobante/ventas', 'VentasController@comprobante');
Route::get('ventas/by/clientes/{id}', 'VentasController@ventasByClient');
Route::get('cuentascobrar/by/clientes/{id}', 'CuentasCobrarController@cuentasByClient');

Route::get('shopify/orders', 'VentasController@Ordenes');
Route::get('shopify/products', 'VentasController@Products');
Route::get('shopify/orders/{id}', 'VentasController@OrdenesSingle');
Route::get('shopify/products/{id}', 'VentasController@ProductsSingle');
Route::get('vendedores/estadistica/barra', 'VentasController@estadisticaVendedoresBarra');
Route::get('clientes/estadistica/barra', 'VentasController@estadisticaClientesBarra');
Route::get('ventas/estadistica/barra', 'VentasController@estadisticaVentasBarra');
Route::get('ventas/estadistica/pie', 'VentasController@estadisticaVentasPie');
Route::get('clientes/estadistica/pie', 'VentasController@estadisticaClientesPie');
Route::get('vendedores/estadistica/pie', 'VentasController@estadisticaVendedoresPie');

Route::post('login', 'AuthenticateController@login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
