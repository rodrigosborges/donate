<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Doacao;
use App\Bairro;
use App\Usuario;

use DB;

class AppController extends Controller{

	public function anuncios(Request $request){
		$dados = $request->all();
		$anuncios = Doacao::where('aprovado',1)->where('doado',0)
			->join('bairros','bairros.id','=','doacoes.bairro_id')
			->join('cidades','cidades.id','=','bairros.cidade_id')
			->join('usuarios','usuarios.id','=','doacoes.usuario_id')
		->join('categorias','categorias.id','=','doacoes.categoria_id');
		if(isset($dados['categoria_id']))
			$anuncios = $anuncios->where('categoria_id',$dados['categoria_id']);
		if(isset($dados['cidade_id']))
			$anuncios = $anuncios->where('cidade_id',$dados['cidade_id']);
		if(isset($dados['email']))
			$anuncios = $anuncios->where('usuarios.email',$dados['email']);
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

	public function checkarAuth(Request $request){
		$dados = $request->only('email','password');
		return json_encode(Auth::attempt($dados));
	}

	public function logarUsuario(Request $request){
		$dados = $request->only('email','password');
		if(Auth::attempt($dados)){
			return json_encode([
				"nome" => Auth::user()->nome,
			]);
		}else
			return json_encode(false);
	}

	public function bairros($cidade_id){
		return Bairro::where('cidade_id',$cidade_id)->select("id as key","nome as label")->get();
	}

	public function anuncioInsert(Request $request){
		file_put_contents(base_path()."/request.txt", json_encode($request->all()));
		DB::beginTransaction();
		try{

			$usuario = Usuario::where('email',$request->email)->first();
			$request['usuario_id'] = $usuario->id;

			if($usuario->nivel == 1)
				$request['aprovado'] = 1;

			$anuncio = Doacao::create($request->all());

			foreach ($request->anexos as $key => $imagem) {
				$upload = $imagem->storeAs("anuncio_$anuncio->id", "DonateImage_$key.png");
			}

			DB::commit();
			return json_encode([true, ["Anúncio cadastrado"]]);
		}catch(Exception $e){
			DB::rollback();
			return json_encode([false,$e->getMessage()]);
		}
	}
}