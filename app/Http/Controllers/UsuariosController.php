<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Helpers\FormatterHelper;
use App\Helpers\UsuariosHelper;
use App\Usuario;
use App\Doacao;
use App\Avaliacao;
use App\Log;

use DB;

class UsuariosController extends Controller{

    public function perfil($id){

    	$usuario = Usuario::find($id);
    	$usuario->data_criacao_formatada = FormatterHelper::formatarDataParaBr($usuario->created_at);
    	$anuncios = Doacao::where('usuario_id', $id)->where('aprovado', 1)->get();
    	
		$avaliacoes = Avaliacao::select('nivel')->where('avaliado_id', $id)->get();

		$avaliacaoMedia = UsuariosHelper::calcularAvaliacaoMedia($avaliacoes);

	    return view('usuarios.perfil', compact("usuario", "anuncios", "avaliacaoMedia"));

	}

	public function editar($id){

		$usuario = Usuario::find($id);

		if($usuario->id != Auth::user()->id && Auth::user()->nivel != 1){
			return redirect('/')->with('warning', 'Desculpe, você não tem permissão para realizar esta ação!');
		}

		return view('auth.register', compact("usuario"));

	}

	public function update(Request $request){
		DB::beginTransaction();
		try{
			$usuario = Usuario::find($request['usuario_id']);

			if($usuario->id != Auth::user()->id && Auth::user()->nivel != 1){
				return redirect('/')->with('warning', 'Desculpe, você não tem permissão para realizar esta ação!');
			}

			$usuario->nome = $request['nome'];
			$usuario->email = $request['email'];

			$usuario->save();

			DB::commit();
			return redirect('/usuarios/perfil/'.$usuario->id)->with('status', 'Perfil atualizado com sucesso!');

		}catch(Exception $e){
			DB::rollback();
			return back()->with("status", $e->getMessage());
		}

	}

	public function alterarSenha($id){

		if(Auth::user()->id != $id && Auth::user()->nivel != 1){
			return redirect('/')->with('warning', 'Desculpe, você não tem permissão para executar esta ação!');
		}

		$usuario = Usuario::find($id);

		return view('usuarios.alterar-senha', compact("usuario"));
	}

	public function updateSenha(Request $request){
		DB::beginTransaction();
		try{
			if(Auth::user()->id != $request['usuario_id'] && Auth::user()->nivel != 1){
				return redirect('/')->with('warning', 'Desculpe, você não tem permissão para executar esta ação!');
			}

			$usuario = Usuario::find($request['usuario_id']);

			if (!Hash::check($request['senha_atual'], $usuario->password)) {
				return back()->with('warning', 'A senha informada não corresponde com a senha atual!');
			}

			if($request['nova_senha'] !== $request['confirmar_nova_senha']){
				return back()->with('warning', 'A nova senha não corresponde com a confirmação');
			}

			$usuario->password = Hash::make($request->nova_senha);
			$usuario->save();

			DB::commit();
			return redirect('/usuarios/perfil/'.$usuario->id)->with('status', 'Senha atualizada com sucesso!');

		}catch(Exception $e){
			DB::rollback();
			return back()->with("status", $e->getMessage());
		}

	}

	public function logs(){
		$logs = Log::orderBy('created_at', 'DESC')->paginate(10);

		return view('usuarios.logs', compact("logs"));
	}
	
}