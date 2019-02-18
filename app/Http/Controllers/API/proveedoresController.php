<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Proveedor;

class proveedoresController extends Controller
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
    
        return Proveedor::select('id','nombre','rif','direccion','telefono','status')->orderby('id','desc')->paginate(10);
    }

    public function selectProveedor(Request $request){
        $filtro=$request->filtro;

        $proveedor= Proveedor::select('id','nombre','rif')->where('nombre','like','%'. $filtro . '%')->orderby('id','desc')->get();
            
        return $proveedor ; 
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
            'nombre' => 'required|string|max:191',
            'rif'=>'required|string|min:6|unique:proveedores',
            
        ]);

        return Proveedor::create([
            'nombre' =>$request['nombre'],
            'rif' =>$request['rif'],
            'direccion' =>$request['direccion'],
            'telefono' =>$request['telefono'],
            'status' =>$request['status'],
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
            $proveedor= Proveedor:: where(function($query) use ($buscar){
                $query->where('nombre','LIKE', "%$buscar%")->orWhere('rif','LIKE',"%$buscar%");

            })->paginate(20);
        }

        return $proveedor; //retorna toda la consulta
    }

    
        //return ["mensaje"=>"Actualizado"];
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'rif' => 'required|string|max:191',
            
        ]);

        
        $proveedor->update($request->all());
}
  }


