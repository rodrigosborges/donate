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
Route::get('/doacoes/pesquisa', 'DoacoesController@pesquisa');

//Para usuários logados
Route::middleware('auth')->group(function () {
    //#### DOACOES #####
    Route::get('/doacoes/create', 'DoacoesController@create');
    Route::post('/doacoes/buscarBairros', 'DoacoesController@buscarBairros');
	Route::post('/doacoes/insert', 'DoacoesController@insert');
	Route::get('/doacoes/meus-anuncios', 'DoacoesController@meusAnuncios');
	Route::get('/doacoes/editar/{id}', 'DoacoesController@editar');
	Route::post('/doacoes/update', 'DoacoesController@update');
    Route::post('/doacoes/delete', 'DoacoesController@delete');
    Route::post('/doacoes/restore', 'DoacoesController@restore');
    Route::get('/doacoes/aguardando-aprovacao', 'DoacoesController@aguardandoAprovacao');
    Route::post('/doacoes/mudarStatus', 'DoacoesController@mudarStatus');
	//##################

    //#### USUARIOS #####
    Route::get('/usuarios/perfil/{id}', 'UsuariosController@perfil');
    Route::get('/usuarios/editar/{id}', 'UsuariosController@editar');
    Route::post('/usuarios/update', 'UsuariosController@update');
    Route::get('/usuarios/alterar-senha/{id}', 'UsuariosController@alterarSenha');
    Route::post('/usuarios/updateSenha', 'UsuariosController@updateSenha');
    Route::get('/usuarios/logs', 'UsuariosController@logs');
    Route::get('/usuarios/mensagens', 'MensagensController@index');
    Route::get('/usuarios/mensagens/buscarMensagens', 'MensagensController@buscarMensagens');
    Route::post('/usuarios/mensagens/enviar', 'MensagensController@enviar');

    //###################

    //#### AVALIAÇÕES ####
    Route::get('/avaliacoes/avaliar', 'AvaliacoesController@avaliar');
    //####################

    //#### OUTRAS ROTAS ####
    // Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    // Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    // Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    // Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    // Password reset link request routes...
    // Route::get('password/email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.email');
    // Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

    // // Password reset routes...
    // Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    // Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');
    //######################
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
    Route::post('checkarAuth', 'AppController@checkarAuth');
    Route::post('logarUsuario', 'AppController@logarUsuario');
    Route::get('bairros/{id}', 'AppController@bairros');
    Route::post('dadosUsuario', 'AppController@dadosUsuario');
    Route::post('doacoes/insert', 'AppController@anuncioInsert');
    Route::post('doacoes/update', 'AppController@anuncioUpdate');
    Route::post('usuario/insert', 'AppController@usuarioInsert');
    Route::post('usuario/update', 'AppController@usuarioUpdate');
    Route::post('conversas','AppController@conversas');
    Route::post('mensagens','AppController@mensagens');
    Route::post('enviarMensagem','AppController@enviarMensagem');
    Route::post('deleteRestoreAnuncio','AppController@deleteRestoreAnuncio');
    Route::post('alterarStatus','AppController@alterarStatus');
});