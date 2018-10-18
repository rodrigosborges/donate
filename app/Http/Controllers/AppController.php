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
		$anuncios = Doacao::where('aprovado',1)->where('doado',0)->join('bairros','bairros.id','=','doacoes.bairro_id')->join('cidades','cidades.id','=','bairros.cidade_id')->join('usuarios','usuarios.id','=','doacoes.usuario_id')
		->join('categorias','categorias.id','=','doacoes.categoria_id');
		if(isset($dados['categoria_id']))
			$anuncios = $anuncios->where('categoria_id',$dados['categoria_id']);
		if(isset($dados['cidade_id']))
			$anuncios = $anuncios->where('cidade_id',$dados['cidade_id']);
		$anuncios = $anuncios->select('doacoes.titulo as titulo','descricao','categorias.nome as categoriaNome','bairros.nome as bairroNome', 'cidades.nome as cidadeNome','doacoes.created_at as data', 'doacoes.id as id','usuarios.nome as usuarioNome')->orderBy('doacoes.created_at','desc')->paginate(10);
		foreach($anuncios as $key => $anuncio){
			$imagens = [];
			foreach($anuncio->getImagens() as $imagem){
				$imagens[] = url(explode('donate/', $imagem)[1]."?time=".Date("Y-m-d H:i:s"));
			}
			$anuncios[$key]->imagens = $imagens;
		}
		return json_encode($anuncios);
	}
}