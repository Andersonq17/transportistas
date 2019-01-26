<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sindicato;

class sindicatoController extends Controller
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
    
        return Sindicato::join('personas','personas.id','=','sindicato.id_persona')
        ->select('sindicato.id','sindicato.nombre','sindicato.rif','sindicato.direccion','sindicato.telefono','sindicato.correo','sindicato.estado',
        'personas.id as id_persona','personas.nombre as presidente','personas.apellido as apellido','personas.cedula as cedula')
        ->paginate(5);
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
            'rif' => 'required|string|max:15',
            'correo'=>'required|string|unique:sindicato',
            
            
        ]);

        return Sindicato::create([
            'nombre' =>$request['nombre'],
            'rif' =>$request['rif'],
            'direccion' =>$request['direccion'],
            'telefono' =>$request['telefono'],
            'correo' =>$request['correo'],
            'estado' =>$request['estado'],
            'id_persona' =>$request['id_persona'],
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
            $sindicatos= Sindicato:: where(function($query) use ($buscar){
                $query->where('nombre','LIKE', "%$buscar%")->orWhere('rif','LIKE',"%$buscar%");

            })->paginate(20);
        }

        return $sindicatos; //retorna toda la consulta
    }

    public function selectSindicato(){
        $sindicatos= Sindicato::select('id','nombre')->orderby('id','asc')->get();
            
        return $sindicatos ; 
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
        $sindicatos = Sindicato::findOrFail($id);

        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'rif' => 'required|string|max:15',
            'correo' => 'required|string|email|max:191|unique:sindicato,correo,'.$sindicatos->id,
            'id_persona' => 'required|integer|',
            
        ]);

        
        $sindicatos->update($request->all());
        
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
        $sindicatos = Sindicato::findOrFail($id);

        $sindicatos->delete();

        //return['mensaje' => 'Usuario eliminado'];
    }
}
