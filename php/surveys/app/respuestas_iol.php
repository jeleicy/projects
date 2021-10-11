<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class respuestas_iol extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'respuestas_iol';
	
    protected $fillable = ['id_candidato','nro_prueba','id_opcion','respuesta'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
