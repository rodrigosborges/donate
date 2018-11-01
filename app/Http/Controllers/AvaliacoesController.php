<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Avaliacao;
use Auth;

class AvaliacoesController extends Controller
{

    public function avaliar(Request $request){

        $avaliacaoExistente = Avaliacao::where('avaliador_id', Auth::id())->where('avaliado_id', $request->avaliado_id)->first();

        if($avaliacaoExistente == null){
            $avaliacao = new Avaliacao();
            $avaliacao = $avaliacao->create($request->all());
        }else{
            $avaliacao = $avaliacaoExistente;
            $avaliacao->nivel = $request->nivel;
            $avaliacao->save();
        }

        return json_encode($avaliacao);

    }

}
