<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usuarios extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'usuarios';

    protected $fillable = ['nombres','id_empresas','email','rol','password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	 
    public function setContrasenaAttribute($value) {
        $this->attributes['password'] = hash('ripemd160', $value);
    }	 
}
