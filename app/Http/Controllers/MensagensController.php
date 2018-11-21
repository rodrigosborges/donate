<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mensagem;
use Illuminate\Support\Facades\DB;
//use App\Mensagem;
use Auth;

class MensagensController extends Controller{

    public function index(){

        $usuarios = DB::select("SELECT IF(remetente_id = ".Auth::id().", destinatario_id, remetente_id) AS outra_pessoa, MAX(mensagens.created_at) AS ultima_msg, nome FROM mensagens JOIN usuarios on usuarios.id = IF(remetente_id = ".Auth::id().",destinatario_id, remetente_id) WHERE destinatario_id = ".Auth::id()." OR remetente_id = ".Auth::id()." GROUP BY outra_pessoa ORDER BY ultima_msg DESC;");
        return view('usuarios.mensagens', compact("usuarios"));
    }

    public function buscarMensagens(Request $request){

    	$mensagens = Mensagem::where(function ($query) use ($request){
            $query->where('remetente_id',Auth::id())
                ->where('destinatario_id',$request->destinatario_id);
            })
            ->orWhere(function ($query) use ($request){
                $query->where('remetente_id',$request->destinatario_id)
                    ->where('destinatario_id',Auth::id());
            })
            ->join('usuarios as remetente', 'mensagens.remetente_id','=','remetente.id')
            ->join('usuarios as destinatario', 'mensagens.destinatario_id','=','destinatario.id')
            ->select('remetente.nome as remetente','destinatario.nome as destinatario','mensagens.texto', 'mensagens.created_at', 'remetente.id as remetente_id')
            ->get();

    	return json_encode($mensagens);
    }

    public function enviar(Request $request){
    	$mensagem = new Mensagem;

    	$request['remetente_id'] = Auth::id();

    	$mensagem = $mensagem->create($request->all());

    	return back()->with('status', 'Mensagem enviada com sucesso!');
    }

}
