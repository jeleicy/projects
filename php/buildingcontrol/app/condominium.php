<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class condominium extends Model
{
    //
    protected $table = 'condominium';
    protected $fillable = ['name','address','manager','logo','phone']; 
  
}
