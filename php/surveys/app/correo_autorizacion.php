<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class correo_autorizacion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'correo_autorizacion';

    protected $fillable = ['id_autorizacion','id_correo','tipo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */	 
}
