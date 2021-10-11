<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class autorizaciones_iol_alt extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'autorizaciones_iol_alt';

    protected $fillable = ['id_empresas','id_usuario', 'id_invitador', 'id_tipo_prueba', 'nombre_evaluado','correo_evaluado','fecha','presento','id_candidato','id_idioma'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */ 
}
