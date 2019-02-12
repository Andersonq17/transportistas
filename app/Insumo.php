<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = [
        'marca', 'tipo', 'medidas_caucho','amperaje','tipo_aceite'
    ];

    public $timestamps=false;
}
