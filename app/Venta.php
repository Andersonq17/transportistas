<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table ='ventas';

    protected $fillable=[
        'idunidad',
        'idusuario',
        'tipo_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'total',
        'estado',
        'observaciones'
    ];

    public function unidades(){
        return $this->belongsTo('App\Unidades');
    }

    public function usuarios(){
        return $this->belongsTo('App\User');
    }
}
