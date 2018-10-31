<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\FormatterHelper;
use App\Usuario;
use App\Doacao;

use DB;

class UsuariosController extends Controller{

    public function perfil($id){

    	$usuario = Usuario::find($id);
    	$usuario->data_criacao_formatada = FormatterHelper::formatarDataParaBr($usuario->created_at);
    	$anuncios = Doacao::where('usuario_id', $id)->where('aprovado', 1)->get();

	    return view('usuarios.perfil', compact("usuario", "anuncios"));

	}
	
}