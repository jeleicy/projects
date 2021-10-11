<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pruebas_asignadas extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'pruebas_asignadas';
    protected $fillable = ['id_usuario_asignador','id_usuario_asignado','id_empresa','id_tipo_prueba','nro_asignadas','nro_presentadas'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
