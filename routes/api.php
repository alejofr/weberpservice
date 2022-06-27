<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * Crear - Create
*/
Route::post('paises', 'App\Http\Controllers\PaisesController@store');
Route::post('monedas', 'App\Http\Controllers\MonedasController@store');
Route::post('tipos-cambios', 'App\Http\Controllers\MonedasCambiosController@store');
Route::post('tazas-cambios', 'App\Http\Controllers\MonedasCambiosTazasController@store');
Route::post('empresas', 'App\Http\Controllers\EmpresasConstroller@store');
Route::post('cecos', 'App\Http\Controllers\CecosController@store');
Route::post('proveedores', 'App\Http\Controllers\ProveedoresController@store');
Route::post('proveedores/load', 'App\Http\Controllers\ProveedoresController@load');
Route::post('facturas', 'App\Http\Controllers\FacturasController@store');
Route::post('facturas/load', 'App\Http\Controllers\FacturasController@load');


/**
 * Lectura - Read
*/

Route::get('paises', 'App\Http\Controllers\PaisesController@index');
Route::get('paises/all', 'App\Http\Controllers\PaisesController@paisesAll');
Route::get('paises/{pais}/edit', 'App\Http\Controllers\PaisesController@edit');
Route::get('monedas', 'App\Http\Controllers\MonedasController@index');
Route::get('monedas/all', 'App\Http\Controllers\MonedasController@monedas_disponibles');
Route::get('monedas/{moneda}/edit', 'App\Http\Controllers\MonedasController@edit');
Route::get('tipos-cambios', 'App\Http\Controllers\MonedasCambiosController@index');
Route::get('tipos-cambios/all', 'App\Http\Controllers\MonedasCambiosController@cambios_disponibles');
Route::get('tipos-cambios/{cambio}/edit', 'App\Http\Controllers\MonedasCambiosController@edit');
Route::get('tazas-cambios', 'App\Http\Controllers\MonedasCambiosTazasController@index');
Route::get('tazas-cambios/{taza}/edit', 'App\Http\Controllers\MonedasCambiosTazasController@edit');
Route::get('/empresas', 'App\Http\Controllers\EmpresasConstroller@index');
Route::get('empresas/all', 'App\Http\Controllers\EmpresasConstroller@empresasAll');
Route::get('empresas/{empresa}/edit', 'App\Http\Controllers\EmpresasConstroller@edit');
Route::get('cecos', 'App\Http\Controllers\CecosController@index');
Route::get('cecos/all', 'App\Http\Controllers\CecosController@all');
Route::get('cecos/{ceco}/edit', 'App\Http\Controllers\CecosController@edit');
Route::get('condiciones-proveedores/all', 'App\Http\Controllers\CondicionesProveedoresController@all');
Route::get('proveedores', 'App\Http\Controllers\ProveedoresController@index');
Route::get('proveedores/all', 'App\Http\Controllers\ProveedoresController@all');
Route::get('proveedores/{proveedor}/edit', 'App\Http\Controllers\ProveedoresController@edit');
Route::get('facturas', 'App\Http\Controllers\FacturasController@index');



/**
 * AlTerar - Alter
 * ( Modificar & Eliminar ) 
*/

//modificar

Route::put('paises/{pais}', 'App\Http\Controllers\PaisesController@update');
Route::put('monedas/{moneda}', 'App\Http\Controllers\MonedasController@update');
Route::put('tipos-cambios/{cambio}', 'App\Http\Controllers\MonedasCambiosController@update');
Route::put('tazas-cambios/{taza}', 'App\Http\Controllers\MonedasCambiosTazasController@update');
Route::put('empresas/{empresa}', 'App\Http\Controllers\EmpresasConstroller@update');
Route::put('cecos/{ceco}', 'App\Http\Controllers\CecosController@update');
Route::put('proveedores/{proveedor}', 'App\Http\Controllers\ProveedoresController@update');

//Eliminar

Route::delete('paises/delete/{pais}', 'App\Http\Controllers\PaisesController@delete');
Route::delete('monedas/delete/{moneda}', 'App\Http\Controllers\MonedasController@delete');
Route::delete('tipos-cambios/delete/{cambio}', 'App\Http\Controllers\MonedasCambiosController@delete');
Route::delete('tazas-cambios/delete/{taza}', 'App\Http\Controllers\MonedasCambiosTazasController@delete');
Route::delete('empresas/delete/{empresa}', 'App\Http\Controllers\EmpresasConstroller@delete');
Route::delete('cecos/delete/{ceco}', 'App\Http\Controllers\CecosController@delete');
Route::delete('proveedores/delete/{proveedor}', 'App\Http\Controllers\ProveedoresController@delete');

