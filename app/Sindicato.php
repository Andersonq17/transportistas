<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sindicato extends Model
{
    protected $fillable = [
        'nombre', 'rif', 'direccion','telefono','correo','estado','id_persona'
    ];

    public function persona(){  
        return $this->belongsTo('App\Persona');

    }
}