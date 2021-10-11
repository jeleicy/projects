<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class autorizaciones extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'autorizaciones';

    protected $fillable = ['id_empresas','id_usuario','id_invitador', 'id_tipo_prueba','nombre_evaluado','correo_evaluado','fecha','presento','id_idioma','id_grupo_candidatos'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */ 
}
