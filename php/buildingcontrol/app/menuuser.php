<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class menuuser extends Model
{
    //
    protected $table = 'menuuser';
    protected $fillable = ['idMenu','idUser'];
}
