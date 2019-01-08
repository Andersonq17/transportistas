<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Linea;

class lineasController extends Controller
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
    
        return Linea::join('personas','personas.id','=','.id_persona')
        ->select('lineas.id','lineas.nombre','lineas.rif','lineas.correo','lineas.direccion','lineas.estado','lineas.municipio',
        'lineas.telefono','lineas.tipo_ruta','lineas.id_persona','lineas.cps','lineas.status',
        'personas.id as id_persona','personas.nombre as presidente','personas.apellido as apellido')
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
            'nombre' => 'required|string|max:191',
            'rif' => 'required|string|max:15|unique:lineas',
            'correo'=>'required|string|unique:lineas',
            'id_persona' => 'required|integer|',
            
        ]);

        return Linea::create([
            'nombre' =>$request['nombre'],
            'rif' =>$request['rif'],
            'correo' =>$request['correo'],
            'direccion' =>$request['direccion'],
            'estado' =>$request['estado'],
            'municipio' =>$request['municipio'],
            'telefono' =>$request['telefono'],
            'tipo_ruta' =>$request['tipo_ruta'],
            'id_persona' =>$request['id_persona'],
            'cps' =>$request['cps'],
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
            $lineas= Linea:: where(function($query) use ($buscar){
                $query->where('nombre','LIKE', "%$buscar%")->orWhere('rif','LIKE',"%$buscar%")
                ->orWhere('estado','LIKE',"%$buscar%")->orWhere('municipio','LIKE',"%$buscar%")
                ->orWhere('tipo_ruta','LIKE',"%$buscar%");

            })->paginate(20);
        }

        return $lineas; //retorna toda la consulta
    }

    public function selectLinea(){
        $lineas= Linea::select('id','nombre')->orderby('id','asc')->get();
            
        return $lineas ; 
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
        $lineas = Linea::findOrFail($id);

        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'rif' => 'required|string|max:15|unique:lineas,rif,'.$lineas->id,
            'correo' => 'required|string|email|max:191|unique:lineas,correo,'.$lineas->id,
            'id_persona' => 'required|integer|',
            
        ]);

        
        $lineas->update($request->all());
        
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
        $lineas = Linea::findOrFail($id);

        $lineas->delete();

        //return['mensaje' => 'Usuario eliminado'];
    }
}

