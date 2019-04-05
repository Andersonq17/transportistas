<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Ingreso;

class escritorioController extends Controller
{
   
    
    public function graph(Request $request)
    {
        $anio= date('Y');
        $ingresos=DB::table('ingresos as i')
            ->select(DB::raw('MONTH(i.fecha_hora) as mes'),
                     DB::raw('YEAR(i.fecha_hora) as anio'),
                     DB::raw('SUM(i.total) as total'))
                     ->whereYear('i.fecha_hora',$anio)
                     ->groupBy(DB::raw('MONTH(i.fecha_hora)'),DB::raw('YEAR(i.fecha_hora)'))->get();

                     return ['ingresos'=>$ingresos, 'anio'=>$anio];
    }
}
