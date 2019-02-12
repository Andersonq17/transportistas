<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table ='detalle_ingreso';
    protected $fillable=[
        'idingreso',
        'idinsumo',
        'cantidad',
        'precio'
    ];

    public $timestamps=false;
}
