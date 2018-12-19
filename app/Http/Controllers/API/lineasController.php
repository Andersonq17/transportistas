<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        ->select('lineas_transporte.id','lineas_transporte.nombre','lineas_transporte.rif','lineas_transporte.direccion','lineas_transporte.telefono','lineas_transporte.correo','lineas_transporte.estado',
        'personas.id as id_persona','personas.nombre as presidente','personas.apellido as apellido')
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
            $sindicatos= Sindicato:: where(function($query) use ($buscar){
                $query->where('nombre','LIKE', "%$buscar%")->orWhere('rif','LIKE',"%$buscar%");

            })->paginate(20);
        }

        return $sindicatos; //retorna toda la consulta
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

