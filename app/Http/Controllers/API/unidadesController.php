<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Unidades;

class unidadesController extends Controller
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
        return Unidades::join('personas','personas.id','=','.id_persona')
                      ->join('lineas', 'lineas.id','=','id_linea')
        ->select('unidades.id','unidades.marca','unidades.modelo','unidades.anio','unidades.placa','unidades.tipo','unidades.numero_cupo',
        'unidades.status','unidades.id_linea','unidades.id_persona',
        'personas.id as id_persona','personas.nombre as propietario','personas.apellido as apellido', 'lineas.nombre as nombre_linea')
        ->paginate(10);
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
            'modelo' => 'required|string|max:191',
            'placa'=>'required|string|unique:unidades',
            'id_linea'=>'required|integer',
            'id_persona' => 'required|integer|',
            'tipo'=>'required'
            
        ]);

        return Unidades::create([
            'marca' =>$request['marca'],
            'modelo' =>$request['modelo'],
            'anio' =>$request['anio'],
            'placa' =>$request['placa'],
            'tipo' =>$request['tipo'],
            'numero_cupo' =>$request['numero_cupo'],
            'status' =>$request['status'],
            'id_linea' =>$request['id_linea'],
            'id_persona' =>$request['id_persona'],
        ]);

        
    }

    public function selectUnidad(Request $request){
        $filtro=$request->filtro;

        $unidad= Unidades::select('id','marca','placa')->where('placa','like','%'. $filtro . '%')->orderby('id','desc')->get();
            
        return $unidad ; 
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
            $unidades= Unidades:: where(function($query) use ($buscar){
                $query->where('marca','LIKE', "%$buscar%")->orWhere('modelo','LIKE',"%$buscar%")
                ->orWhere('placa','LIKE',"%$buscar%")->orWhere('numero_cupo','LIKE',"%$buscar%")
                ->orWhere('id_linea','LIKE',"%$buscar%");

            })->paginate(20);
        }

        return $unidades; //retorna toda la consulta
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
        $unidades = Unidades::findOrFail($id);

        $this->validate($request,[
            'marca' => 'required|string|max:191',
            'placa' => 'required|string|max:15|unique:lineas,rif,'.$unidades->id,
            'modelo' => 'required|string|max:191',
            'id_linea'=>'required|integer',
            'id_persona' => 'required|integer|',
            
        ]);

        
        $unidades->update($request->all());
        
        //return ['mensaje','editando'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $unidades = Unidades::findOrFail($id);

        $unidades->delete();

        //return['mensaje' => 'Usuario eliminado'];
    } 
}

