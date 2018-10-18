<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nome
 * @property string $icon
 * @property Doaco[] $doacoes
 */
class Categoria extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['nome', 'icon'];
    public $timestamps = false;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function doacoes(){
        return $this->hasMany('App\Doacao');
    }

}