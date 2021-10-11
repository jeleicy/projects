<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    //
    protected $table = 'items';
    protected $fillable = ['name','presentation','idCondominium'];
}
