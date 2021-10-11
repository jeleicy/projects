<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jobposition extends Model
{
    //
    protected $table = 'jobposition';
    protected $fillable = ['idEmployee','name','begindate','enddate'];    
}
