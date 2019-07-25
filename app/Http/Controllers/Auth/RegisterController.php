<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ParametroController;
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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombres' => ['required', 'string', 'max:50'],
            'apellidos' => ['required', 'string', 'max:50'],
            'username'  => ['required', 'string', 'max:10', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'ciudad' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
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
        return view('user.index',compact('users','title'));
    }

    public function new(){
        $title = 'Nuevo Usuario';
        $activo = TRUE;
        $ciudades = ParametroController::getCiudades();
        $datos_vista = compact('activo','title','ciudades');
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
        $activo = FALSE;
        return view('user.form',compact('user','activo','title'));
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
        $title = 'Actualizar Usuario';
        $activo = TRUE;
        $datos_vista = compact('activo','title','user','ciudades');
        return view('user.form',$datos_vista);
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
