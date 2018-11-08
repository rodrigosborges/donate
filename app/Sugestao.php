<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $usuario_id
 * @property string $sugestao
 * @property Usuario $usuario
 */
class Sugestao extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sugestoes';

    /**
     * @var array
     */
    protected $fillable = ['usuario_id', 'sugestao'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo('App\Usuario');
    }
}
