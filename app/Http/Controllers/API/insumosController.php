<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Insumo;


class insumosController extends Controller
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
    
        return Insumo::select('id','marca','tipo','medidas_caucho','amperaje','tipo_aceite')->orderby('id','desc')->paginate(10);
    }

    public function selectInsumo(Request $request){
        $insumo= Insumo::select('id','nombre','rif')->where('status','=','1')->orderby('id','desc')->get();
            
        return $insumo ; 
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
            'marca' => 'required|string|max:191',
            
            
        ]);

        return Insumo::create([
            'marca' =>$request['marca'],
            'tipo' =>$request['tipo'],
            'medidas_caucho' =>$request['medidas_caucho'],
            'amperaje' =>$request['amperaje'],
            'tipo_aceite' =>$request['tipo_aceite'],
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
            $insumo= Insumo:: where(function($query) use ($buscar){
                $query->where('marca','LIKE', "%$buscar%")->orWhere('tipo','LIKE',"%$buscar%");

            })->paginate(20);
        }

        return $insumo; //retorna toda la consulta
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
        $insumo = Insumo::findOrFail($id);

        $this->validate($request,[
            'marca' => 'required|string|max:191',

            
        ]);

        
        $insumo->update($request->all());
}
  
}
