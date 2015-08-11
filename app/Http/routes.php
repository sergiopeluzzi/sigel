<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => '/', 'uses' => 'PrincipalController@index', 'middleware' => 'auth']);

Route::group(['prefix' => 'auth'], function() {
    Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@postLogin']);
    Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);
});

Route::group(['prefix' => 'competidores', 'middleware' => 'auth'], function() {

    Route::get('/', ['as' => 'competidores.index', 'uses' => 'CompetidoresController@index']);
    Route::get('create', ['as' => 'competidores.create', 'uses' => 'CompetidoresController@create']);
    Route::post('store', ['as' => 'competidores.store', 'uses' => 'CompetidoresController@store']);
    Route::get('edit/{id}', ['as' => 'competidores.edit', 'uses' => 'CompetidoresController@edit']);
    Route::put('update/{id}', ['as' => 'competidores.update', 'uses' => 'CompetidoresController@update']);
    Route::get('destroy/{id}', ['as' => 'competidores.destroy', 'uses' => 'CompetidoresController@destroy']);

});



Route::group(['prefix' => 'eventos', 'middleware' => 'auth'], function() {

    Route::get('/', ['as' => 'eventos.index', 'uses' => 'EventosController@index']);

});

Route::group(['prefix' => 'inscricoes', 'middleware' => 'auth'], function() {

    Route::get('/', ['as' => 'inscricoes.index', 'uses' => 'InscricoesController@index']);

});

Route::group(['prefix' => 'sorteios', 'middleware' => 'auth'], function() {

    Route::get('/', ['as' => 'sorteios.index', 'uses' => 'SorteiosController@index']);
});
