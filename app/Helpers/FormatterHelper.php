<?php

namespace App\Helpers;

class FormatterHelper{

	public static function formatarDataParaBr($data){

		$data = explode(" ", $data)[0]; 

		$ano = explode("-", $data)[0];
		$mes = explode("-", $data)[1];
		$dia = explode("-", $data)[2];

		return $dia."/".$mes."/".$ano;

	}

}