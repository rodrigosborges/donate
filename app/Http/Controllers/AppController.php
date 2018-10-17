<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Doacao;

use DB;

class AppController extends Controller{

	public function anuncios(Request $request){
		$dados = $request->all();
		$anuncios = Doacao::where('aprovado',1)->where('doado',0)->join('bairros','bairros.id','=','doacoes.bairro_id')->join('cidades','cidades.id','=','bairros.cidade_id');
		if(isset($dados['categoria_id']))
			$anuncios = $anuncios->where('categoria_id',$dados['categoria_id']);
		if(isset($dados['cidade_id']))
			$anuncios = $anuncios->where('cidade_id',$dados['cidade_id']);
		$anuncios->select('doacoes.titulo as titulo','bairros.nome as bairro_nome', 'cidades.nome as cidade_nome','doacoes.created_at as data', 'doacoes.id as id');
		return json_encode($anuncios->orderBy('created_at','desc')->paginate(10));
	}

	public function anuncio($id){
		$doacao = Doacao::select('id','titulo','descricao','created_at','bairro_id','categoria_id','usuario_id')->find($id);
		if($doacao->doado != 0 && $doacao->aprovado != 1)
			return false;
		$doacao->bairroNome = $doacao->bairro->nome;
		$doacao->categoriaNome = $doacao->categoria->nome;
		$doacao->cidadeNome = $doacao->bairro->cidade->nome;
		$doacao->categoriaNome = $doacao->categoria->nome;
		$doacao->usuarioNome = $doacao->usuario->nome;
		return json_encode($doacao);
	}
}