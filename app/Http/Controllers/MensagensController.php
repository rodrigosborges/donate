<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mensagem;
//use App\Mensagem;
use Auth;

class MensagensController extends Controller{

    public function index(){

    	$mensagens = Mensagem::select('destinatario_id')->where('remetente_id', Auth::id())->orWhere('destinatario_id', Auth::id())->groupBy("destinatario_id")->get();

    	foreach ($mensagens as $key => $mensagem) {
    		if($mensagem->destinatario['id'] !== Auth::id()){
    			$usuarios[$key]['id'] = $mensagem->destinatario['id'];
    			$usuarios[$key]['nome'] = $mensagem->destinatario['nome'];
    		}
    	}

        return view('usuarios.mensagens', compact("usuarios"));
    }

    public function buscarMensagens(Request $request){

    	$mensagens = Mensagem::where('remetente_id', $request->destinatario_id)->orWhere('destinatario_id', $request->destinatario_id)->get();

    	foreach ($mensagens as $mensagem) {
    		$mensagem['remetente'] = $mensagem->remetente['nome'];
    		$mensagem['destinatario'] = $mensagem->destinatario['nome'];
    	}

    	return json_encode($mensagens);
    }

    public function enviar(Request $request){
    	$mensagem = new Mensagem;

    	$request['remetente_id'] = Auth::id();

    	$mensagem = $mensagem->create($request->all());

    	return back()->with('status', 'Mensagem enviada com sucesso!');
    }

}
