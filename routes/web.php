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

	$anuncios = Doacao::where('aprovado',1)->where('doado', 0)->limit(4)->orderBy('created_at', 'desc')->get();
    $categorias = Categoria::all();

    return view('home', compact("anuncios", "categorias"));

});

Auth::routes();

Route::get('/doacoes/anuncio/{id}', 'DoacoesController@anuncio');
Route::get('/doacoes/anuncios/{categoria}', 'DoacoesController@anuncios');

//Para usuários logados
Route::middleware('auth')->group(function () {
    //#### DOACOES #####
    Route::get('/doacoes/create', 'DoacoesController@create');
	Route::post('/doacoes/insert', 'DoacoesController@insert');
	Route::get('/doacoes/meus-anuncios', 'DoacoesController@meusAnuncios');
	Route::get('/doacoes/editar/{id}', 'DoacoesController@editar');
	Route::post('/doacoes/update', 'DoacoesController@update');
    Route::post('/doacoes/pesquisa', 'DoacoesController@pesquisa');
    Route::post('/doacoes/mudarStatus', 'DoacoesController@mudarStatus');
	//##################

    //#### USUARIOS #####
    Route::get('/usuarios/perfil/{id}', 'UsuariosController@perfil');
    Route::get('/usuarios/mensagens', 'MensagensController@index');
    Route::get('/usuarios/mensagens/buscarMensagens', 'MensagensController@buscarMensagens');
    Route::post('/usuarios/mensagens/enviar', 'MensagensController@enviar');
    //###################

    //#### AVALIAÇÕES ####
    Route::get('/avaliacoes/avaliar', 'AvaliacoesController@avaliar');
    //####################
});
//#####################

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/categorias/grid', 'CategoriasController@grid');
Route::resource('/categorias', 'CategoriasController');
// Route::get('/doacoes/grid', 'DoacoesController@grid');
//Route::resource('/doacoes', 'DoacoesController');

//Rotas do app

Route::prefix('app')->group(function () {
    Route::get('anuncios', 'AppController@anuncios');
    Route::get('checkarAuth', 'AppController@checkarAuth');
    Route::get('logarUsuario', 'AppController@logarUsuario');
    Route::get('bairros/{id}', 'AppController@bairros');
    Route::post('doacoes/insert', 'AppController@anuncioInsert');
});