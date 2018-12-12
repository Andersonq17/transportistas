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
    
        return Sindicato::latest()->paginate(5);
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
            'rif' => 'required|string|min:12',
            'correo'=>'required|string|unique:sindicato',
            'id_persona' => 'required|integer|',
            
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
        $personas = Sindicato::findOrFail($id);

        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'rif' => 'required|string|min:12',
            'correo'=>'required|string|unique:sindicato',
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
