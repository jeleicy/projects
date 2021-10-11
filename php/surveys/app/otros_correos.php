<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class otros_correos extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'otros_correos';

    protected $fillable = ['id_autorizacion','coreos'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */ 
}
