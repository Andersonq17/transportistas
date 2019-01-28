<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Linea;
use App\Persona;
use App\Unidades;
use App\Sindicato;

class Pdfcontroller extends Controller
{
    public function index (){
        //return view('pdf.listado_reportes');
    }

    public function crearPdf($datos, $vistaurl,$tipo){
        $data = $datos;
        $date = date('d-m-Y');
        $view= \View::make($vistaurl, compact('data','date'))->render();
        $pdf= \App::make('dompdf.wrapper');
        $pdf->loadHtml($view);

        if($tipo==1){return $pdf->stream('reporte');}
        if($tipo==2){return $pdf->download('reporte.pdf');}

    }

    public function reporte_lineas($tipo){
        $vistaurl="pdf.reporte_lineas";
        $lineas=Linea::all();

        return $this->crearPdf($lineas,$vistaurl,$tipo);
    }

}
