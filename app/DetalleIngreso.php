<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table ='detalle_ingresos';
    protected $fillable=[
        'idingreso',
        'idinsumo',
        'cantidad',
        'precio'
    ];

    public function ingreso(){
        return $this->belongsTo('App\Ingreso');
    }

    public $timestamps=false;
}
