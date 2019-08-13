<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //
    public function index(){
        $opciones = MenuController::getMenu(auth()->user()->id);
        $datos_vista = compact('opciones');
        return view('welcome',$datos_vista);
    }

    
}
