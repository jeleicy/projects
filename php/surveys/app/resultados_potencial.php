<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class resultados_potencial extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'resultados_potencial';

    protected $fillable = ['id_autorizacion', 'id_candidato','id_opciones','valor'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
