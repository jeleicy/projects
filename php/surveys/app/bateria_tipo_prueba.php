<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bateria_tipo_prueba extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'bateria_tipo_prueba';
	
    protected $fillable = ['id_bateria','id_tipo_prueba'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
