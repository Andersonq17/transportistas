<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Linea;
use App\Persona;
use App\Unidades;
use App\Sindicato;
use App\Venta;
use App\DetalleVenta;

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

    public function crearPdf2($datos1, $datos2, $vistaurl,$id){
        $data = $datos1;
        $data2= $datos2;
        $date = date('d-m-Y');
        $view= \View::make($vistaurl, compact('data','data2','date'))->render();
        $pdf= \App::make('dompdf.wrapper');
        $pdf->loadHtml($view);

        return $pdf->stream('reporte.pdf');

    }

    public function reporte_lineas($tipo){
        $vistaurl="pdf.reporte_lineas";
        $lineas=Linea::all();

        return $this->crearPdf($lineas,$vistaurl,$tipo);
    }

    public function reporte_unidades($tipo){
        $vistaurl="pdf.reporte_unidades";
        $unidad=Unidades::join('lineas', 'lineas.id','=','id_linea')
        ->select('unidades.marca','unidades.modelo','unidades.anio','unidades.placa','unidades.tipo','unidades.numero_cupo',
        'unidades.status','lineas.nombre as nombre_linea')->get();

        return $this->crearPdf($unidad,$vistaurl,$tipo);
    }

    public function reporte_persona($tipo){
        $vistaurl="pdf.reporte_choferes";
        $persona=Persona::all();

        return $this->crearPdf($persona,$vistaurl,$tipo);
    }

    public function reporte_venta(Request $request,$id){
        $vistaurl="pdf.venta";
        $venta= Venta::join('unidades','ventas.idunidad','=','unidades.id')
                        ->join('users','ventas.idusuario','=','users.id')
                        ->select('ventas.id','ventas.tipo_comprobante','ventas.num_comprobante','ventas.created_at',
                                'ventas.impuesto','ventas.total','ventas.estado','ventas.observaciones',
                                'unidades.marca','unidades.modelo','unidades.placa','users.name')
                                ->where('ventas.id','=',$id)->
                                orderBy('ventas.id','desc')->take(1)->get();
        
        $detalles=DetalleVenta::join('insumos','detalle_venta.idinsumo','=','insumos.id')
                                    ->select('detalle_venta.cantidad','detalle_venta.precio',
                                            'insumos.marca as marca','insumos.tipo as tipo','insumos.medidas_caucho as medida',
                                            'insumos.amperaje as amperaje','insumos.tipo_aceite as tipoA')
                                            ->where('detalle_venta.idventa','=',$id)
                                            ->orderBy('detalle_venta.id','desc')->get();

        //$numventa= Venta::select('num_comprobante')->where('id','=',$id)->get();

        return $this->crearPdf2($venta,$detalles,$vistaurl,$id);
    }
}
