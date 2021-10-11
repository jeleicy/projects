<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bateria extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'bateria';

    protected $fillable = ['nombre','activa'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */	 
}
