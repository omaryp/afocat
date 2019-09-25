<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Validator;

class FileController extends Controller
{
    public function __construct(){  
        $this->middleware('auth');
    }
    //
    public function index(){
        $title = 'Carga de Archivos';
        $files = FileLoadController::listarArchivos();
        $opciones = MenuController::getMenu(auth()->user()->id);
        return view('file.form',compact('title','files','opciones'));
    }

    public function oldload(Request $request){

        $data = request()->validate([
            'archivo'=>'required|unique:file_loads,nombre|mimes:xlsx,xls',
        ]);
        
        $file = $request->file('archivo');
        $nombre_real = $file->getClientOriginalName();
        $ruta_servidor = $file->store('fileafocat');
        FileLoadController::store($nombre_real,$ruta_servidor);
        $files = FileLoadController::listarArchivos();
        $title = 'Carga de Archivos';
        $mensaje = 'Archivo cargado corectamente';
        $opciones = MenuController::getMenu(auth()->user()->id);
        return view('file.form',compact('title','mensaje','files','opciones'));
    }

    public function load(Request $request){
        $data= request()->all();
        $file = $request->file('archivo');
        $data['name'] = $file->getClientOriginalName();

        $reglas = [
            'archivo'=>'required|mimes:xlsx,xls',
            'name'=>'unique:file_loads,nombre'
        ];  
        $validar = Validator::make($data, $reglas);
        if ($validar->passes()) {
            $ruta_servidor = $file->store('fileafocat');
            FileLoadController::store($data['name'],$ruta_servidor);
            $files = FileLoadController::listarArchivos();
            $title = 'Carga de Archivos';
            $mensaje = 'Archivo cargado corectamente';
            $opciones = MenuController::getMenu(auth()->user()->id);
            return view('file.form',compact('title','mensaje','files','opciones'));
        }else{
            if ($validar->fails()) {
                return redirect('/storage')
                            ->withErrors($validar)
                            ->withInput();
            }
        }
    }

    public function destroy($id){
        $fileLoad = FileLoadController::getArchivo($id);
        if(File::exists(storage_path('app').'/'.$fileLoad->ubicacion)){
            File::delete(storage_path('app').'/'.$fileLoad->ubicacion);
            $fileLoad->delete();
            return response()->json([
                'success' => true,
                'mensaje' => 'Se eliminó archivo correctamente !!!',
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'mensaje' => 'El archivo no existe !!!',
            ], 404);
        }
    }
}
