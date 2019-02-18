<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ingreso;
use App\DetalleIngreso;

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
        ->select('ingresos.id','ingresos.idproveedor','ingresos.idusuario','ingresos.tipo_comprobante','ingresos.serie_comprobante','ingresos.num_comprobante',
        'ingresos.fecha_hora','ingresos.impuesto','ingresos.total','ingresos.estado','proveedores.nombre','users.name as nombre_usuario')
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
        $this->validate($request,[
            'idproveedor' => 'required|string|max:191',
            'tipo_comprobante' => 'required|string|max:191',
            'num_comprobante'=>'required|string|min:191',
            
            
        ]);

        return Ingreso::create([
            'idproveedor' =>$request['nombre'],
            'idusuario' =>\Auth::usuario['idusuario']->id,
            'tipo_comprobante' =>$request['tipo_comprobante'],
            'serie_comprobante' =>$request['serie_comprobante'],
            'num_comprobante' =>$request['num_comprobante'],
            'fecha_hora' =>$request['fecha_hora'],
            'impuesto'=>$request['impuesto'],
            'total'=>$request['total'],
            'estado'=>$request['estado']='Registrado'
        ]);

        return DetalleIngreso::create([
            'idingreso'=>$request['idingreso'],
            'idinsumo'=>$request['idinsumo'],
            'cantidad'=>$request['cantidad'],
            'precio'=>$request['precio']
        ]);

        
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
