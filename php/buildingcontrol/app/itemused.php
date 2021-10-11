<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class itemused extends Model
{
    //
    protected $table = 'itemused';
    protected $fillable = ['idActivitieEmployee','idItem','idEmployee','quantity','idBuilding','date','idCondominium'];
}
