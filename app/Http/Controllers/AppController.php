<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\FormatterHelper;
use App\Doacao;
use App\Bairro;
use App\Usuario;
use App\Mensagem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\DoacoesHelper;


use DB;

class AppController extends Controller{

	public function anuncios(Request $request){
		try{
			$dados = $request->all();
			$anuncios = Doacao::join('bairros','bairros.id','=','doacoes.bairro_id')
				->join('cidades','cidades.id','=','bairros.cidade_id')
				->join('usuarios','usuarios.id','=','doacoes.usuario_id')
				->join('categorias','categorias.id','=','doacoes.categoria_id');

			if(isset($dados['categoria_id']))
				$anuncios = $anuncios->where('categoria_id',$dados['categoria_id']);

			if(isset($dados['cidade_id']))
				$anuncios = $anuncios->where('cidade_id',$dados['cidade_id']);

			if(isset($dados['id'])){
				$anuncios = $anuncios->where('usuarios.id',$dados['id'])->withTrashed();
			}else{
				$anuncios = $anuncios->where('doado',0)->where('aprovado',1);
			}

			if(isset($dados['pesquisa'])){
				$anuncios = $anuncios->where(function ($query) use($dados){
					return $query->where('titulo', 'like', '%'.$dados['pesquisa'].'%')
					->orWhere('descricao', 'like', '%'.$dados['pesquisa'].'%');
				});
			}

			$anuncios = $anuncios->select('doado', 'aprovado', 'doacoes.deleted_at','doacoes.titulo as titulo','descricao','categorias.nome as categoriaNome','bairros.nome as bairroNome', 'cidades.nome as cidadeNome','doacoes.created_at as data', 'doacoes.id as id','usuarios.nome as usuarioNome', 'usuarios.id as doador_id', 'categorias.id as categoria','bairros.id as bairro', 'cidades.id as cidade')->orderBy('doacoes.created_at','desc')->paginate(10);
			foreach($anuncios as $key => $anuncio){
				$imagens = [];
				foreach($anuncio->getImagens() as $imagem){
					$imagens[] = url(explode('donate/', $imagem)[1]."?time=".Date("Y-m-d H:i:s"));
				}
				$anuncios[$key]->imagens = $imagens;
				$usuario = Usuario::find($anuncio->doador_id);
				if($usuario->avaliacoes()->count() == 0)
					$anuncios[$key]->avaliacao = "Não avaliado";
				else
					$anuncios[$key]->avaliacao = round($usuario->avaliacoes()->avg('nivel'),2)+" de 5";
			}
			return json_encode($anuncios);
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public function checkarAuth(Request $request){
		$dados = $request->only('email','password');
		if(Auth::attempt($dados)){
			Auth::user()->remember_token = Hash::make('remember_token');
			Auth::user()->save();
			return json_encode([
				"token" => Auth::user()->remember_token,
				"nome" => Auth::user()->nome,
				"id" => Auth::id(),
			]);
		}else
			return json_encode(false);
	}

	public function logarUsuario(Request $request){
		$dados = $request->only('email','password');
		if(Auth::attempt($dados)){
			Auth::user()->remember_token = Hash::make('remember_token');
			Auth::user()->save();
			return json_encode([
				"nome" => Auth::user()->nome,
				"id" => Auth::id(),
				"token" => Auth::user()->remember_token,
			]);
		}else
			return json_encode(false);
	}

	public function bairros($cidade_id){
		return Bairro::where('cidade_id',$cidade_id)->select("id as key","nome as label")->get();
	}

	public function dadosUsuario(Request $request){
		$usuario = Usuario::find($request->id);
		if($usuario->remember_token != $request->token)
			return false;
		return json_encode([
			"cadastro" => FormatterHelper::formatarDataParaBr($usuario->created_at),
			"anunciados" => $usuario->doacoes()->where('aprovado',1)->count(),
			"doados" => $usuario->doacoes()->where('aprovado',1)->where('doado','1')->count(),
			"avaliacao" => round($usuario->avaliacoes()->avg('nivel'),1),
		]);
	}

	public function anuncioInsert(Request $request){
		DB::beginTransaction();
		try{
			file_put_contents("results.txt",json_encode($request->all()));
			$usuario = Usuario::find($request->usuario_id);
			if($usuario->remember_token != $request->token)
				return json_encode([false, ["Cadastro não permitido"]]);

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

	public function anuncioUpdate(Request $request){
		DB::beginTransaction();
		try{
			$usuario = Usuario::find($request->usuario_id);
			$anuncio = Doacao::find($request->id);
			if($usuario->remember_token != $request->token || $request->usuario_id != $anuncio->usuario_id)
			return json_encode([false, ["Edição não permitida"]]);
			
			if($usuario->nivel == 1)
				$request['aprovado'] = 1;
			else
				$request['aprovado'] = 0;
			
			$anuncio->update($request->all());
			
			if($request->arquivoExcluir){
				foreach($request->arquivoExcluir as $arquivo){
					$arquivo = explode("?",explode("/",$arquivo)[count(explode("/",$arquivo))-1])[0];
					unlink(base_path()."/storage/app/anuncio_$anuncio->id/$arquivo");
				}
			}

			if($request->anexos){
				foreach ($request->anexos as $imagem) {
					$numero = DoacoesHelper::proximoNumeroImagem($anuncio);
					$upload = $imagem->storeAs("anuncio_$anuncio->id", "DonateImage_$numero.png");
				}
			}

			DB::commit();
			return json_encode([true, ["Anúncio atualizado"]]);
		}catch(Exception $e){
			DB::rollback();
			return json_encode([false,$e->getMessage()]);
		}
	}

	public function usuarioInsert(Request $request){
		DB::beginTransaction();
		try{
			Usuario::create([			
				'nome' 		=> $request->nome,
				'email' 	=> $request->email,
				'password' 	=> Hash::make($request->password),
				'nivel'		=> 2
			]);
			DB::commit();
			return json_encode(true);
		}catch(Exception $e){
			DB::rollback();
			return json_encode(false);
		}
	}

	public function usuarioUpdate(Request $request){
		DB::beginTransaction();
		try{
			$usuario = Usuario::find($request->id);
			if($usuario->remember_token != $request->token)
				return false;
			$cadastro = [
				'nome' 		=> $request->nome,
				'email' 	=> $request->email,
			];
			if($request->password != "")
				$cadastro['password'] = Hash::make($request->password);
			$usuario->update($cadastro);
			DB::commit();
			return json_encode(true);
		}catch(Exception $e){
			DB::rollback();
			return json_encode(false);
		}
	}
	public function conversas(Request $request){
		$usuario = Usuario::find($request->id);
		if($usuario->remember_token != $request->token)
			return false;
        $usuarios = DB::select("SELECT IF(remetente_id = ".$request->id.", destinatario_id, remetente_id) AS outra_pessoa,texto, MAX(mensagens.created_at) AS ultima_msg, nome FROM mensagens JOIN usuarios on usuarios.id = IF(remetente_id = ".$request->id.",destinatario_id, remetente_id) WHERE destinatario_id = ".$request->id." OR remetente_id = ".$request->id." GROUP BY outra_pessoa ORDER BY ultima_msg DESC;");
		return json_encode($usuarios);
	}

    public function mensagens(Request $request){
		$usuario = Usuario::find($request->id);
		if($usuario->remember_token != $request->token)
			return false;
    	$mensagens = Mensagem::where(function ($query) use ($request){
			$query->where('remetente_id',$request->id)
				->where('destinatario_id',$request->destinatario_id);
			})
			->orWhere(function ($query) use ($request){
				$query->where('remetente_id',$request->destinatario_id)
					->where('destinatario_id',$request->id);
			})
			->join('usuarios as remetente', 'mensagens.remetente_id','=','remetente.id')
			->join('usuarios as destinatario', 'mensagens.destinatario_id','=','destinatario.id')
			->select('remetente.nome as remetente','destinatario.nome as destinatario','mensagens.texto', 'mensagens.created_at', 'remetente.id as remetente_id')
			->paginate(10);

    	return json_encode($mensagens);
	}
	
    public function enviarMensagem(Request $request){
		DB::beginTransaction();
		try{
			$usuario = Usuario::find($request->id);
			if($usuario->remember_token != $request->token)
				return false;

			$mensagem = new Mensagem;
			$mensagem->remetente_id = $request->id;
			$mensagem->destinatario_id = $request->destinatario_id;
			$mensagem->texto = $request->texto;
			$mensagem->save();

			DB::commit();
			return json_encode(true);
		}catch(Exception $e){
			DB::rollback();
			return json_encode(false);
		}
	}
	
	public function deleteRestoreAnuncio(Request $request){
		try{
			$usuario = Usuario::find($request->id);
			if($usuario->remember_token != $request->token)
				return json_encode(false);
			$anuncio = Doacao::withTrashed()->where('id',$request->anuncio_id)->first();
			if($anuncio->trashed() != null)
				$anuncio->restore();
			else
				$anuncio->delete();
			return json_encode(true);
		}catch(Exception $e){
			DB::rollback();
			return json_encode(false);
		}
	} 

	public function alterarStatus(Request $request){
		try{
			$usuario = Usuario::find($request->id);
			if($usuario->remember_token != $request->token)
				return json_encode(false);
			$anuncio = Doacao::find($request->anuncio_id);
			$anuncio->doado = $anuncio->doado == 1 ? 0 : 1;
			$anuncio->update();
			return json_encode(true);
		}catch(Exception $e){
			DB::rollback();
			return json_encode(false);
		}	
	}
}
