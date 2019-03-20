<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table ='detalle_venta';

    protected $fillable=[
        'idventa',
        'idinsumo',
        'precio',
        'cantidad',
        
    ];

    public function venta(){
        return $this->belongsTo('App\Venta');
    }

    public function insumos(){
        return $this->belongsTo('App\Insumo');
    }
    
    public $timestamps=false;
}
