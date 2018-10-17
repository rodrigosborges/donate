<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doacao;
use App\Categoria;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $anuncios = Doacao::all();
        $categorias = Categoria::all();

        return view('home', compact("anuncios", "categorias"));

    }

}
