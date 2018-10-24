<?php

use App\Doacao;
use App\Categoria;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

	$anuncios = Doacao::all();
    $categorias = Categoria::all();

    return view('home', compact("anuncios", "categorias"));

});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//#### DOACOES #####
Route::post('/doacoes/insert', 'DoacoesController@insert');
Route::get('/doacoes/meus-anuncios', 'DoacoesController@meusAnuncios');
Route::get('/doacoes/anuncio/{id}', 'DoacoesController@anuncio');
Route::get('/doacoes/editar/{id}', 'DoacoesController@editar');
Route::post('/doacoes/update', 'DoacoesController@update');
//##################


// Route::get('/categorias/grid', 'CategoriasController@grid');
Route::resource('/categorias', 'CategoriasController');
// Route::get('/doacoes/grid', 'DoacoesController@grid');
Route::resource('/doacoes', 'DoacoesController');


//Rotas do app

Route::prefix('app')->group(function () {
    Route::get('anuncios', 'AppController@anuncios');
});