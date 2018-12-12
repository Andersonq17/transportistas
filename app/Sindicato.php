<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sindicato extends Model
{
    protected $table='sindicatos';
    protected $fillable = [
        'nombre', 'rif', 'direccion','telefono','correo','estado','id_persona'
    ];
    //public $timestamps= false;

    public function persona(){  
        return $this->belongsTo('App\Persona');

    }
}