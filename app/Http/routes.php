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
    Route::get('create', ['as' => 'eventos.create', 'uses' => 'EventosController@create']);
    Route::get('show/{id}', ['as' => 'eventos.show', 'uses' => 'EventosController@show']);
    Route::post('store', ['as' => 'eventos.store', 'uses' => 'EventosController@store']);
    Route::get('edit/{id}', ['as' => 'eventos.edit', 'uses' => 'EventosController@edit']);
    Route::put('update/{id}', ['as' => 'eventos.update', 'uses' => 'EventosController@update']);
    Route::get('destroy/{id}', ['as' => 'eventos.destroy', 'uses' => 'EventosController@destroy']);

});

Route::group(['prefix' => 'inscricoes', 'middleware' => 'auth'], function() {

    Route::get('/', ['as' => 'inscricoes.index', 'uses' => 'InscricoesController@index']);
    Route::get('inscricoes', ['as' => 'inscricoes.inscricoes', 'uses' => 'InscricoesController@inscricoes']);
    Route::post('inscrever', ['as' => 'inscricoes.inscrever', 'uses' => 'InscricoesController@inscrever']);
    Route::get('destroy/{id}', ['as' => 'inscricoes.destroy', 'uses' => 'InscricoesController@destroy']);

});

Route::group(['prefix' => 'sorteios', 'middleware' => 'auth'], function() {

    Route::get('/', ['as' => 'sorteios.index', 'uses' => 'SorteiosController@index']);
    Route::post('processar', ['as' => 'sorteios.processar', 'uses' => 'SorteiosController@processar']);
    Route::post('visualizar', ['as' => 'sorteios.visualizar', 'uses' => 'SorteiosController@visualizar']);
    Route::get('visualizar/inserir/{id}', ['as' => 'sorteios.visualizar.inserir', 'uses' => 'SorteiosController@inserir']);
    Route::get('visualizar/editar/{id}', ['as' => 'sorteios.visualizar.editar', 'uses' => 'SorteiosController@editar']);
    Route::post('salvar', ['as' => 'sorteios.salvar', 'uses' => 'SorteiosController@salvar']);
    Route::post('deletar', ['as' => 'sorteios.deletar', 'uses' => 'SorteiosController@deletar']);
});

Route::group(['prefix' => 'relatorios', 'middleware' => 'auth'], function() {

    Route::get('teste', ['as' => 'relatorios.teste', 'uses' => 'RelatoriosController@teste']);
    Route::get('listaGeral', ['as' => 'relatorios.listaGeral', 'uses' => 'RelatoriosController@listaGeral']);
    Route::post('listaGeral/imprimir', ['as' => 'relatorios.imprimirListaGeral', 'uses' => 'RelatoriosController@imprimirListaGeral']);
    Route::get('marcacaoProva', ['as' => 'relatorios.marcacaoProva', 'uses' => 'RelatoriosController@marcacaoProva']);
    Route::post('marcacaoProva/imprimir', ['as' => 'relatorios.imprimirMarcacaoProva', 'uses' => 'RelatoriosController@imprimirMarcacaoProva']);
    Route::get('ficha', ['as' => 'relatorios.ficha', 'uses' => 'RelatoriosController@ficha']);
    Route::post('ficha/imprimir', ['as' => 'relatorios.imprimirFicha', 'uses' => 'RelatoriosController@imprimirFicha']);
    Route::get('listaProva', ['as' => 'relatorios.listaProva', 'uses' => 'RelatoriosController@listaProva']);
    Route::post('listaProva/imprimir', ['as' => 'relatorios.imprimirListaProva', 'uses' => 'RelatoriosController@imprimirListaProva']);

});


