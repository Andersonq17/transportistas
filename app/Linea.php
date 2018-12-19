<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    protected $fillable=['nombre','rif','direccion','telefono','tipo_ruta','id_persona','cps','status'];

    public $timestamps= false;

    public function persona(){  
        return $this->belongsTo('App\Persona');
    }
}
