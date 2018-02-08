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

Route::get('vendedores/estadistica', 'VentasController@estadisticaVendedores');
Route::post('login', 'AuthenticateController@login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
