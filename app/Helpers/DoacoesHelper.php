<?php

namespace App\Helpers;

class DoacoesHelper{

	public static function proximoNumeroImagem($doacao){

		foreach ($doacao->getImagens() as $imagem) {
			$numero = explode("DonateImage_", $imagem)[1];
			$numero = explode(".png", $numero)[0];
			$numeros[] = $numero;	
		}

		return max($numeros) + 1;

	}

}