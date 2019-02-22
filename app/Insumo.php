<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = [
        'codigo','marca', 'tipo', 'medidas_caucho','amperaje','tipo_aceite','existencia'
    ];

    public $timestamps=false;
}
