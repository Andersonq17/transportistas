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

