<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'nombre', 'apellido', 'cedula','telefono','correo'
    ];

    public function sindicato(){
        return $this->hasOne('App\Sindicato');
    }
}
