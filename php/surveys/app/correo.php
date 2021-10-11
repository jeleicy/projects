<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class correo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'correo';

    protected $fillable = ['texto','nombre','texto','activa','id_prueba','tipo','asunto','id_empresa','id_idioma'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */	 
}
