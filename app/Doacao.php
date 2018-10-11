<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $usuario_id
 * @property int $bairro_id
 * @property int $categoria_id
 * @property string $titulo
 * @property string $descricao
 * @property boolean $aprovado
 * @property boolean $doado
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Bairro $bairro
 * @property Categoria $categoria
 * @property Usuario $usuario
 * @property Imagen[] $imagens
 */
class Doacao extends Model{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'doacoes';

    /**
     * @var array
     */
    protected $fillable = ['usuario_id', 'bairro_id', 'categoria_id', 'titulo', 'descricao', 'aprovado', 'doado', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bairro()
    {
        return $this->belongsTo('App\Bairro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoria()
    {
        return $this->belongsTo('App\Categoria');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo('App\Usuario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function imagens()
    {
        return $this->hasMany('App\Imagem', 'doacao_id');
    }
}   