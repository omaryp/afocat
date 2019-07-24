<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametro;

class ParametroController extends Controller
{
    //
    public static function getCiudades(){
        return Parametro::where('codigo','=',1)->where('codtab','<>','')->get();
    }
    
}
