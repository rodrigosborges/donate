<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome', 'email', 'password', 'remember_token','nivel',
    ];

    protected $hidden = [
        'password', 'remember_token','created_at','updated_at','deleted_at','nivel','email', 'id'
    ];

    public function doacoes(){
        return $this->hasMany('App\Doacao');
    }

    public function avaliacoes(){
        return $this->hasMany('App\Avaliacao','avaliado_id');
    }

    public function mensagens(){
        return $this->hasMany('App\Mensagem');
    }
}
