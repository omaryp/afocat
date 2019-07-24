<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class FileController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    //
    public function index(){
        $title = 'Carga de Archivos';
        $files = FileLoadController::listarArchivos();
        return view('file.form',compact('title','files'));
    }

    public function load(Request $request){

        $data = request()->validate([
            'archivo'=>'required',
        ]);
        
        $file = $request->file('archivo');
        $nombre_real = $file->getClientOriginalName();
        $ruta_servidor = $file->store('fileafocat');
        FileLoadController::store($nombre_real,$ruta_servidor);
        $files = FileLoadController::listarArchivos();
        $title = 'Carga de Archivos';
        $mensaje = 'Archivo cargado corectamente';
        return view('file.form',compact('title','mensaje','files'));
    }

    public function destroy($id){
        $fileLoad = FileLoadController::getArchivo($id);
        if(File::exists(storage_path('app').'/'.$fileLoad->ubicacion)){
            File::delete(storage_path('app').'/'.$fileLoad->ubicacion);
            $fileLoad->delete();
            return response()->json([
                'success' => true,
                'archivo' => 'Se eliminó archivo correctamente !!!',
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'mensaje' => 'El archivo no existe !!!',
            ], 404);
        }
    }
}
