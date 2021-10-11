<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class grupo_candidatos extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'grupo_candidatos';

    protected $fillable = ['nombre','id_empresa','activa'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */	 
}
