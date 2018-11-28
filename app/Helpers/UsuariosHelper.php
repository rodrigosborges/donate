<?php

namespace App\Helpers;

class UsuariosHelper{

	public static function calcularAvaliacaoMedia($avaliacoes){
		$somaDasNotas = 0;

		foreach ($avaliacoes as $avaliacao) {
			$somaDasNotas += $avaliacao->nivel;
		}

		if(count($avaliacoes) != 0){
			$avaliacaoMedia = $somaDasNotas / count($avaliacoes);
		}else{
			$avaliacaoMedia = "não avaliado";
		}

		return $avaliacaoMedia;
	}

}