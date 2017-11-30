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

Route::resource('tiposcompra', 'TiposCompraController');
Route::resource('tiposventa', 'TiposVentaController');
Route::resource('tiposdetallecompras', 'TiposDetalleComprasController');
Route::resource('tiposdetalleventas', 'TiposDetalleVentasController');
Route::resource('roles', 'RolesController');
Route::resource('puestos', 'PuestosController');

Route::post('login', 'AuthenticateController@login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
