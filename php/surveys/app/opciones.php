<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class opciones extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'opciones';
	
    protected $fillable = ['id','id_pregunta','opcion','respuesta','id_categoria','fecha_creacion','activo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
