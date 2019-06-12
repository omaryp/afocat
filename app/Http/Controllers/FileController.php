<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    //
    public function index(){
        $title = 'Carga de Archivos';
        $files = FileLoadController::listarArchivos();
        return view('file.form',compact('title','files'));
    }

    public function load(Request $request){

        $data = request()->validate([
            'carga'=>'required',
        ]);

        $file = $request->file('carga');
        $nombre_real = $file->getClientOriginalName();
        $ruta_servidor = $file->store('ventas');
        FileLoadController::store($nombre_real,$ruta_servidor);
        $files = FileLoadController::listarArchivos();
        $title = 'Carga de Archivos';
        $mensaje = 'Archivo cargado corectamente';
        return view('file.form',compact('title','mensaje','files'));
    }
}
