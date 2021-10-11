<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class preguntas extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'preguntas';
	
    protected $fillable = ['id_tipo_prueba','pregunta','respuesta','imagen','orden','id_idioma','fecha_creacion','activo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
