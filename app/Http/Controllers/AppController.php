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
		$anuncios = $anuncios->select('doacoes.titulo as titulo','bairros.nome as bairro_nome', 'cidades.nome as cidade_nome','doacoes.created_at as data', 'doacoes.id as id')->orderBy('created_at','desc')->paginate(10);
		foreach($anuncios as $key => $anuncio){
			$anuncios[$key]->imagem = url(explode('donate/', $anuncio->getImagens()[0])[1]."?time=".Date("Y-m-d H:i:s"));
		}
		return json_encode($anuncios);
	}

	public function anuncio($id){
		$anuncio = Doacao::select('id','titulo','descricao','created_at','bairro_id','categoria_id','usuario_id')->find($id);
		if($anuncio->doado != 0 && $anuncio->aprovado != 1)
			return false;
		$anuncio->bairroNome = $anuncio->bairro->nome;
		$anuncio->categoriaNome = $anuncio->categoria->nome;
		$anuncio->cidadeNome = $anuncio->bairro->cidade->nome;
		$anuncio->categoriaNome = $anuncio->categoria->nome;
		$anuncio->usuarioNome = $anuncio->usuario->nome;
		$imagens = [];
		foreach($anuncio->getImagens() as $imagem){
			$imagens[] = url(explode('donate/', $imagem)[1]."?time=".Date("Y-m-d H:i:s"));
		}
		$anuncio->imagens  = $imagens;
		return json_encode($anuncio);
	}
}