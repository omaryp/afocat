<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{

    public function __construct(){
        $this->middleware('guest',['only'=>'showLogin']);
    }

    public function login(){
        $data = request()->validate([
            'username'=>'required|string',
            'password'=>'required|string',
        ]);
        if(Auth::attempt($data)){
            return redirect()->route('welcome');
        }
        return back()->withErrors(['username'=>trans('auth.failed')])
            ->withInput(request(['username']));
    }


    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function showLogin(){
        return view('login.form');
    }

    public function username()
    {
        return 'username';
    }
}
