<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipos_pruebas extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'tipos_pruebas';
	
    protected $fillable = ['nombre','activo','id_bateria'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
