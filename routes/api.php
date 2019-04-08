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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['user'=>'API\userController']);
Route::get('Perfil','Api\userController@perfil');
Route::get('buscarUsuario','Api\userController@buscar');

Route::put('Perfil','Api\userController@actPerfil');

Route::put('Perfil','Api\userController@actPerfil');

//personas
Route::apiResources(['personas'=>'API\personasController']);
Route::get('personas', 'Api\personasController@index');
Route::get('buscarPersona','Api\personasController@buscar');
Route::post('personas', 'Api\personasController@store');
Route::put('personas', 'Api\personasController@update');

//sindicatos

Route::apiResources(['sindicatos'=>'API\sindicatoController']);
Route::get('sindicatos', 'Api\sindicatoController@index');
Route::get('selectPersona', 'Api\personasController@selectPersona');
//Route::get('buscarSindicato','Api\sindicatoController@buscar');
Route::post('sindicatos', 'Api\sindicatoController@store');
Route::put('sindicatos', 'Api\sindicatoController@update');

//lineas de transporte
Route::apiResources(['lineas'=>'API\lineasController']);
Route::get('lineas', 'Api\lineasController@index');
Route::get('buscarLinea','Api\lineasController@buscar');
Route::post('lineas', 'Api\lineasController@store');
Route::put('lineas', 'Api\lineasController@update');
Route::get('selectPersona', 'Api\personasController@selectPersona');
Route::get('selectSindicato', 'Api\sindicatoController@selectSindicato');
Route::put('lineasActivar', 'Api\lineasController@activar');
Route::put('lineasDesactivar', 'Api\lineasController@desactivar');

//unidades de transporte
Route::apiResources(['unidades'=>'API\unidadesController']);
Route::get('unidades', 'Api\unidadesController@index');
Route::get('selectPersona', 'Api\personasController@selectPersona');
Route::get('buscarUnidad','Api\unidadesController@buscar');
Route::post('unidades', 'Api\unidadesController@store');
Route::put('unidades', 'Api\unidadesController@update');
Route::get('selectLinea', 'Api\lineasController@selectLinea');
Route::get('selectUnidad', 'Api\unidadesController@selectUnidad');


//reportes
Route::apiResources(['reportes'=>'API\Pdfcontroller']);
Route::get('reporte_lineas/{tipo}', 'Api\Pdfcontroller@reporte_lineas');
Route::get('reporte_unidades/{tipo}', 'Api\Pdfcontroller@reporte_unidades');
Route::get('reporte_persona/{tipo}', 'Api\Pdfcontroller@reporte_persona');
Route::get('reporte_venta/{id}', 'Api\PdfController@reporte_venta');

//proveedores

Route::apiResources(['proveedores'=>'API\proveedoresController']);
Route::get('proveedores', 'Api\proveedoresController@index');
Route::get('selectProveedor', 'Api\proveedoresController@selectProveedor');
Route::get('buscarProveedor','Api\proveedoresController@buscar');
Route::post('proveedores', 'Api\proveedoresController@store');
Route::put('proveedores', 'Api\proveedoresController@update');

//registro de insumos

Route::apiResources(['insumos'=>'API\insumosController']);
Route::get('insumos', 'Api\insumosController@index');
Route::get('listarInsumo', 'Api\insumosController@listarInsumo');
Route::get('selectInsumos', 'Api\insumosController@selectPersona');
Route::get('buscarInsumos','Api\insumosController@buscar');
Route::post('insumos', 'Api\insumosController@store');
Route::put('insumos', 'Api\insumosController@update');
Route::get('buscarPorCodigo', 'Api\insumosController@buscarPorCodigo');

//ingresos insumos

Route::apiResources(['ingreso'=>'API\ingresoController']);
Route::get('ingreso', 'Api\ingresoController@index');
Route::post('ingreso', 'Api\ingresoController@store');
Route::put('ingreso', 'Api\ingresoController@anular');

//ventas

Route::apiResources(['ventas'=>'API\ventasController']);
Route::get('ventas', 'Api\ventasController@index');
Route::post('ventas', 'Api\ventasController@store');
Route::put('ventas', 'Api\ventasController@anular');
Route::get('buscarVenta','Api\ventasController@buscarVenta');

//escritorio
Route::apiResources(['escritorio'=>'API\escritorioController']);
Route::get('escritorio','API\escritorioController@graph');
Route::get('escritorio/venta','API\escritorioController@show');