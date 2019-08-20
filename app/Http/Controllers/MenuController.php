<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Option;

class MenuController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function getMenu($usuariocodigo){
        $opciones = Option::
            select('options.codigo', 
                    'options.descripcion',
                    'options.ruta',
                    'options.tipo',
                    'options.icono')
            ->join('menus', 'options.codigo','=','menus.menu_id')
            ->where('menus.users_id','=',$usuariocodigo)
            ->orderBy('options.orden', 'asc')->get();
        $opciones = MenuController::cargarRutas($opciones);
        return $opciones;
    }

    public static function getOpciones($usuariocodigo){
        $opciones = Option::
            select('options.codigo', 
                    'options.descripcion',
                    'menus.activo')
            ->leftjoin('menus','options.codigo','=','menus.menu_id')
            ->where('menus.users_id','=',$usuariocodigo)
            ->orderBy('options.orden', 'asc')->get();
        return $opciones;
    }

    public static function cargarRutas($opciones){
        foreach ($opciones as $key => $opcion) {
            $opcion->ruta =  url($opcion->ruta);
        }
        return $opciones;
    }

    public static function guardarOpciones($codigoUsuario,$username,$opciones){
        foreach ($opciones as $key => $value) {
            $menu = new Menu();
            $menu->menu_id=$value;
            $menu->users_id=$codigoUsuario;
            $menu->username=$username;
            $menu->activo=1;
            $menu->save();
        }
    }

}
