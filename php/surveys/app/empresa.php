<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class empresa extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'empresas';

    protected $fillable = ['nombre','direccion','logo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */	 
}
