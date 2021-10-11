<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class resultados extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'resultados';
    protected $fillable = ['id_candidato','mas','menos','resta','perfil','pentil_Deseada','pentil_Bajo_Presion','pentil_Cotidiana','nro_prueba'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
