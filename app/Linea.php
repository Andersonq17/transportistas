<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    protected $fillable=['nombre','rif','correo','direccion','estado','municipio','telefono','tipo_ruta','id_persona','id_sindicato','cps','status'];

    public $timestamps= false;

    public function persona(){  
        return $this->belongsTo('App\Persona');
    }
    public function unidades(){  
        return $this->hasMany('App\Unidades','id');
    }
}
