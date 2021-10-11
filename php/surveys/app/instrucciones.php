<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class instrucciones extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'instrucciones';

    protected $fillable = ['texto','nombre','activa','id_prueba','id_idioma','id_empresa','posicion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */	 
}
