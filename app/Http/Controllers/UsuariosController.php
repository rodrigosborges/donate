<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Usuario;
use App\Doacao;

use DB;

class UsuariosController extends Controller{

    public function perfil($id){

    	$usuario = Usuario::find($id);
    	$anuncios = Doacao::where('usuario_id', $id)->get();

	    return view('usuarios.perfil', compact("usuario", "anuncios"));

	}
	
}