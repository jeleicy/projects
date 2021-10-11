<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contenidos_campos extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'contenidos_campos';

    protected $fillable = ['id_campos_candidatos','texto','id_autorizaciones'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */	 
}
