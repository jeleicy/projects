<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class coach extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'coach';

    protected $fillable = ['id_autorizaciones','escuela_formo','tiempo_formo','ano_certificacion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */ 
}
