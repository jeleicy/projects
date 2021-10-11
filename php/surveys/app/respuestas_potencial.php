<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class respuestas_potencial extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'respuestas_potencial';

    protected $fillable = ['id_autorizacion', 'id_candidato','id_preguntas','respuesta'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
