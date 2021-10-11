<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class texto_aceptacion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'texto_aceptacion';

    protected $fillable = ['nombre','texto','id_bateria','id_empresa','activa'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */	 
}
