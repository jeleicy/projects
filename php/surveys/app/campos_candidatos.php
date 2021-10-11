<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class campos_candidatos extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'campos_candidatos';

    protected $fillable = ['id_empresas','nombre','activa','obligatorio','tipo_campo','valores'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */	 
}
