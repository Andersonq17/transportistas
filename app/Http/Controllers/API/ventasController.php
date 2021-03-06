<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Venta;
use App\DetalleVenta;
use App\User;
use Carbon\Carbon;

class ventasController extends Controller
{
    public function __construct()

    
    {
        $this->middleware('auth:api');
        
    }

    public function index()
    {
    
        return Venta::join('unidades','ventas.idunidad','=','unidades.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.idunidad','ventas.idusuario','ventas.tipo_comprobante','ventas.num_comprobante','ventas.observaciones',
        'ventas.fecha_hora','ventas.impuesto','ventas.total','ventas.estado','unidades.placa as placa','users.name as nombre_usuario')
        ->orderby('id','desc')->paginate(10);
    }

    public function store(Request $request)
    {
    
     try{
         DB::beginTransaction();
         $myTime=Carbon::now('America/Caracas')->format('Y-m-d');
         $venta= new Venta();

         $venta->idunidad=$request['idunidad.id'];
         $venta->idusuario= \Auth::user()->id;
         $venta->tipo_comprobante= $request->tipo_comprobante;
         $venta->num_comprobante=$request->num_comprobante;
         $venta->fecha_hora=$myTime;
         $venta->impuesto=$request->impuesto;
         $venta->total=$request->total;
         $venta->estado=$request->estado;
         $venta->observaciones=$request->observaciones;
         $venta->save();

         $detalles=$request->data;//lo que viene del arraydetalle de la vista

         foreach($detalles as $ep => $det) {
            $detalle= new DetalleVenta();

            $detalle->idventa=$venta->id;
            $detalle->idinsumo=$det['idinsumo'];
            $detalle->cantidad=$det['cantidad'];
            $detalle->precio=$det['precio'];
            $detalle->save();
         }
           
         DB::commit();
         return [
             'id' => $venta->id
         ];
     }catch(Exception $e){
         DB::rollback();
     }


    }

    public function buscarVenta() 
    {
       
        if($buscar = \Request::get('q')){
            $ventas= Venta:: join('unidades','idunidad','=','unidades.id')
            ->where(function($query) use ($buscar){
                $query->where('unidades.placa','LIKE',"%$buscar%");
            })->get();
            
        }

        return $ventas; //retorna toda la consulta
    }

    public function update($id)
    {
        $this->authorize('isAdmin');
        $venta = Venta::findOrFail($id);
        $venta->estado='Anulado';
        $venta->save();

    }
}
