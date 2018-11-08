<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mensagem;
use Auth;

class MensagensController extends Controller{

    public function index(){

        return view('usuarios.mensagens');
    }

}
