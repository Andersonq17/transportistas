<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Persona;


class personasController extends Controller
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
    
        return Persona::select('id','nombre','apellido','cedula','telefono','correo','tipo')->orderby('id','desc')->paginate(10);
    }

    public function selectPersona(Request $request){
        $personas= Persona::select('id','nombre','apellido','cedula')->orderby('id','desc')->get();
            
        return $personas ; 
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
            'apellido' => 'required|string|max:191',
            'cedula'=>'required|string|min:6|unique:personas',
           // 'correo' => 'max:191|unique:personas,correo',
            
        ]);

        return Persona::create([
            'nombre' =>$request['nombre'],
            'apellido' =>$request['apellido'],
            'cedula' =>$request['cedula'],
            'telefono' =>$request['telefono'],
            'correo' =>$request['correo'],
            'tipo' =>$request['tipo'],
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
    public function update(Request $request, $id)
    {
        $personas = Persona::findOrFail($id);

        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'apellido' => 'required|string|max:191',
            'cedula'=>'sometimes|min:6',
            'correo' => 'required|string|email|max:191|unique:personas,correo,'.$personas->id,
            
        ]);

        
        $personas->update($request->all());
        
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
        $personas = Persona::findOrFail($id);

        $personas->delete();

        //return['mensaje' => 'Usuario eliminado'];
    }
}
