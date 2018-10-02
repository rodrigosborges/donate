<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $avaliador_id
 * @property int $avaliado_id
 * @property int $nivel
 * @property Usuario $usuario
 * @property Usuario $usuario
 */
class Avaliacao extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'avaliacoes';

    /**
     * @var array
     */
    protected $fillable = ['avaliador_id', 'avaliado_id', 'nivel'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'avaliador_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'avaliado_id');
    }
}
