<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    public function login(){
        $data = request()->validate([
            'username'=>'required|string',
            'password'=>'required|string',
        ]);
        if(Auth::attempt($data)){
            return 'Tu sesión ha iniciado correctamente';
        }
        return back()->withErrors(['username'=>trans('auth.failed')]);
    }
}
