<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    //
    protected $table = 'users';
    protected $fillable = ['user','password','idRole','idEmployee','idCondominium'];
    protected $hidden = [
        'password', 'remember_token',
    ];

}
