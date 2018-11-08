<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $remetente_id
 * @property int $destinatario_id
 * @property string $texto
 * @property string $ created_at
 * @property Usuario $usuario
 * @property Usuario $usuario
 */
class Mensagem extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'mensagens';

    /**
     * @var array
     */
    protected $fillable = ['remetente_id', 'destinatario_id', 'texto', ' created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'remetente_id');
    }
}
