<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $doacao_id
 * @property string $nome
 * @property Doaco $doaco
 */
class Imagem extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'imagens';

    /**
     * @var array
     */
    protected $fillable = ['doacao_id', 'nome'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doaco()
    {
        return $this->belongsTo('App\Doaco', 'doacao_id');
    }
}
