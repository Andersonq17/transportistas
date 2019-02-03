<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table= 'proveedores';

    protected $fillable =[

        'nombre','rif','direccion','telefono','status'

    ];

    public $timestamps=false;
}
