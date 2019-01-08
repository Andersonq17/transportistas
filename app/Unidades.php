<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
    protected $fillable=[
        'marca','modelo','anio','placa','tipo','numero_cupo','status','id_linea','id_persona'
    ];

    public $timestamps = false;

    public function persona(){  
        return $this->belongsTo('App\Persona');
    }
    public function lineas(){  
        return $this->belongsTo('App\Linea');
    }
}
