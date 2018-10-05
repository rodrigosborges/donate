<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $cidade_id
 * @property string $nome
 * @property Cidade $cidade
 * @property Doaco[] $doacoes
 */
class Bairro extends Model
{
    protected $table = 'bairros';
    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['cidade_id', 'nome'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cidade()
    {
        return $this->belongsTo('App\Cidade');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function doacoes()
    {
        return $this->hasMany('App\Doaco');
    }
}
