<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = [
        'marca', 'tipo', 'medida_caucho','amperaje','tipo_aceite'
    ];
}
