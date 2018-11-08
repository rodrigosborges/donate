<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\FormatterHelper;
use App\Usuario;
use App\Doacao;
use App\Avaliacao;

use DB;

class UsuariosController extends Controller{

    public function perfil($id){

    	$usuario = Usuario::find($id);
    	$usuario->data_criacao_formatada = FormatterHelper::formatarDataParaBr($usuario->created_at);
    	$anuncios = Doacao::where('usuario_id', $id)->where('aprovado', 1)->get();

    	$qtdAvaliacoes = [
			'1-star' => Avaliacao::where('avaliado_id', $usuario->id)->where('nivel', 1)->count(),
			'2-star' => Avaliacao::where('avaliado_id', $usuario->id)->where('nivel', 2)->count(),
			'3-star' => Avaliacao::where('avaliado_id', $usuario->id)->where('nivel', 3)->count(),
			'4-star' => Avaliacao::where('avaliado_id', $usuario->id)->where('nivel', 4)->count(),
			'5-star' => Avaliacao::where('avaliado_id', $usuario->id)->where('nivel', 5)->count()
		];

	    return view('usuarios.perfil', compact("usuario", "anuncios", "qtdAvaliacoes"));

	}
	
}