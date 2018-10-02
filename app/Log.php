<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $usuario_id
 * @property string $mensagem
 * @property string $created_at
 * @property Usuario $usuario
 */
class Log extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['usuario_id', 'mensagem', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo('App\Usuario');
    }
}
