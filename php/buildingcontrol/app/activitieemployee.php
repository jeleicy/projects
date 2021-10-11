<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activitieemployee extends Model
{
    //
    protected $table = 'activitiemployee';
    protected $fillable = ['idEmployee','idActivitie','idBuilding','floor','apartment','ActivitiDateTime','Observations', 'idCondominium'];
}
