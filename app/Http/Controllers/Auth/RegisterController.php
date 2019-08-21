<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MenuController; 
use App\Http\Controllers\ParametroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $users = User::
            select('users.id', 
                    'users.nombres',
                    'users.apellidos',
                    'users.ciudad',
                    'parametros.descor',
                    'users.isAdmin', 
                    'users.username')
            ->join('parametros', 'parametros.codtab','=','users.ciudad')
            ->where('parametros.codigo','=',1)
            ->where('parametros.codtab','<>',"''")
            ->orderBy('users.apellidos', 'asc')
            ->paginate(10);
        $title = 'Listado de Usuarios';  
        $opciones = MenuController::getMenu(auth()->user()->id);
        return view('user.index',compact('users','title','opciones'));
    }

    public function new(){
        $title = 'Nuevo Usuario';
        $activo = TRUE;
        $ciudades = ParametroController::getCiudades();
        $opciones = MenuController::getMenu(auth()->user()->id);
        $opciones_guardar = $opciones;
        $datos_vista = compact('activo','title','ciudades','opciones','opciones_guardar');
        return view('user.form',$datos_vista);
    }

    public function show($codigo){
        $user = User::select(
                 'users.id', 
                 'users.nombres', 
                 'users.apellidos',
                 'users.username',
                 'users.ciudad',
                 'users.isAdmin',
                 'parametros.descor', 
                 'users.email',
                 'users.password')
                ->join('parametros', 'parametros.codtab','=','users.ciudad')
                ->where('parametros.codigo','=',1)
                ->where('parametros.codtab','<>',"''")
                ->where('users.id','=',$codigo)
                ->get()->first();
        $title = 'Consulta Usuario';
        $opciones = MenuController::getMenu(auth()->user()->id);
        $opciones_guardar = MenuController::getOpciones(auth()->user()->id);
        $activo = FALSE;
        return view('user.form',compact('user','activo','title','opciones','opciones_guardar'));
    }

    public function edit($codigo){
        $user = User::select(
            'users.id', 
            'users.username', 
            'users.nombres',
            'users.apellidos',
            'users.password', 
            'users.ciudad',
            'users.isAdmin',
            'users.email')
           ->where('users.id','=',$codigo)
           ->get()->first();
        $ciudades = ParametroController::getCiudades();
        $opciones = MenuController::getMenu(auth()->user()->id);
        $opciones_guardar = MenuController::getOpciones(auth()->user()->id);
        $title = 'Actualizar Usuario';
        $activo = TRUE;
        $datos_vista = compact('activo','title','user','ciudades','opciones','opciones_guardar');
        return view('user.form',$datos_vista);
    }

    public function update($codigo){
        $data = request()->validate([
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'username'  => 'required|string|max:10',
            'email' => 'required|string|email|max:255',
            'ciudad' => 'required',
            'password' => 'required|string|min:8|same:cpassword',
            'cpassword' => 'required|string|min:8',
        ]);   
        $user=User::where('id','=',$codigo)->get()->first();
        $data['password'] = bcrypt($data['password']);
        $user->update($data);
        return redirect()->route('users.edit',['codigo' =>$codigo]);
    }

    public function store(){
        $data = request()->validate([
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'username'  => 'required|string|max:10',
            'email' => 'required|string|email|max:255',
            'ciudad' => 'required',
            'password' => 'required|string|min:8|same:cpassword',
            'cpassword' => 'required|string|min:8',
            'opciones' => '',
        ]); 
        $user = new User(); 
        $user->username=$data['username'];
        $user->nombres=$data['nombres'];
        $user->apellidos=$data['apellidos'];
        $user->password=bcrypt($data['password']);
        $user->ciudad=$data['ciudad'];
        $user->isAdmin=0;
        $user->email=$data['email'];
        $user->save();
        MenuController::guardarOpciones($user->id,$user->username,$data['opciones']);
        return redirect()->route('users.edit',['codigo' => $user->id]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     *//*
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }*/
}
