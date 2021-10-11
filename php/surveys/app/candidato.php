<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class candidato extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'candidatos';
    protected $fillable = ['nombres','apellidos','nacionalidad','cedula','sexo','email','edad','nivel_formacion','orientacion_area','orientacion_cargo','fecha_creacion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
