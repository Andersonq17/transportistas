<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Ingreso;
use App\DetalleIngreso;
use App\User;
use Carbon\Carbon;


class ingresoController extends Controller
{
    public function __construct()

    
    {
        $this->middleware('auth:api');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        return Ingreso::join('proveedores','ingresos.idproveedor','=','proveedores.id')
        ->join('users','ingresos.idusuario','=','users.id')
        ->select('ingresos.id','ingresos.idproveedor','ingresos.idusuario','ingresos.tipo_comprobante','ingresos.serie_comprobante','ingresos.num_comprobante', 'ingresos.observaciones',
        'ingresos.fecha_hora','ingresos.impuesto','ingresos.total','ingresos.estado','proveedores.nombre as nombre_proveedor','users.name as nombre_usuario')
        ->orderby('id','desc')->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validaciones en el servidor
       /* $validar= $request->validate([
            'idproveedor' => 'required|max:191',
            'tipo_comprobante' => 'required|string|max:191',
            'num_comprobante'=>'required|string|max:191',
            'impuesto'=> 'required|numeric',
            'idinsumo'=>'required|integer',
            
        ]);*/
    
     try{
         DB::beginTransaction();
         $myTime=Carbon::now('America/Caracas')->format('Y-m-d');
         $ingreso= new Ingreso();

         $ingreso->idproveedor=$request['idproveedor.id'];
         $ingreso->idusuario= \Auth::user()->id;
         $ingreso->tipo_comprobante= $request->tipo_comprobante;
         $ingreso->serie_comprobante=$request->serie_comprobante;
         $ingreso->num_comprobante=$request->num_comprobante;
         $ingreso->fecha_hora=$myTime;
         $ingreso->impuesto=$request->impuesto;
         $ingreso->total=$request->total;
         $ingreso->estado='Registrado';
         $ingreso->observaciones=$request->observaciones;
         $ingreso->save();

         $detalles=$request->data;//lo que viene del arraydetalle de la vista

         foreach($detalles as $ep => $det) {
            $detalle= new DetalleIngreso();

            $detalle->idingreso=$ingreso->id;
            $detalle->idinsumo=$det['idinsumo'];
            $detalle->cantidad=$det['cantidad'];
            $detalle->precio=$det['precio'];
            $detalle->save();
         }
           
         DB::commit();

     }catch(Exception $e){
         DB::rollback();
     }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buscar() 
    {
       
        if($buscar = \Request::get('q')){
            $personas= Persona:: where(function($query) use ($buscar){
                $query->where('nombre','LIKE', "%$buscar%")->orWhere('cedula','LIKE',"%$buscar%")
                ->orWhere('tipo','LIKE',"%$buscar%")->orWhere('apellido','LIKE',"%$buscar%");

            })->paginate(20);
        }

        return $personas; //retorna toda la consulta
    }

    
        //return ["mensaje"=>"Actualizado"];
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function anular($id)
    {
        $this->authorize('isAdmin');
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->estado='Anulado';
        $ingreso->save();

        //return['mensaje' => 'Usuario eliminado'];
    }
}
