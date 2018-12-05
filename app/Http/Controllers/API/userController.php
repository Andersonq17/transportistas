<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
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
        return User::latest()->paginate(15);
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
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password'=>'required|string|min:6'
        ]);

        return User::create([
            'name' =>$request['name'],
            'email' =>$request['email'],
            'type' =>$request['type'],
            'foto'=>$request['foto'],
            'cargo'=>$request['cargo'],
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function perfil()
    {
        return auth('api')->user(); //para mostrar info de usuario en el perfil
    }

    public function actPerfil(Request $request) //actualizar tu info de perfil
    {
        $user= auth('api')->user(); 
        
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password'=>'sometimes|required|min:6'
        ]);

            //validar foto de perfil
        $fotoActual= $user->foto;

        if($request->foto != $fotoActual){

            $name= time(). '.' . explode('/', explode(':', substr($request->foto,0,strpos
            ($request->foto,';')))[1])[1];

            \Image::make($request->foto)->resize(140,120)->save(public_path('img/profile/').$name);
            //$request->foto->resize(320, 240);


            $request->merge(['foto'=> $name]);

            //para borrar la foto anterior de la carpeta
            $userFoto= public_path('img/profile/').$fotoActual;

                if(file_exists($userFoto)){
                    @unlink($userFoto);
                }
        }
            //hashear pass
            if(!empty($request->password)){

            $request->merge(['password'=> Hash::make($request['password'])]);//encriptar la pass al actualizar 
                }
        

            $user->update($request->all());

        //return ["mensaje"=>"Actualizado"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password'=>'sometimes|min:6'
        ]);

        $fotoActual= $user->foto;

        if($request->foto != $fotoActual){

            $name= time(). '.' . explode('/', explode(':', substr($request->foto,0,strpos
            ($request->foto,';')))[1])[1];

            \Image::make($request->foto)->save(public_path('img/profile/').$name);

            $request->merge(['foto'=> $name]);

            //para borrar la foto anterior de la carpeta
            $userFoto= public_path('img/profile/').$fotoActual;

                if(file_exists($userFoto)){
                    @unlink($userFoto);
                }
        }

        if(!empty($request->password)){

            $request->merge(['password'=> Hash::make($request['password'])]);//encriptar la pass al actualizar 
                }

        $user->update($request->all());
        
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
        $user = User::findOrFail($id);

        $user->delete();

        //return['mensaje' => 'Usuario eliminado'];
    }
}
