<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileLoad;

class FileLoadController extends Controller
{
    //
    public static function listarArchivos(){  
        $files = 
        FileLoad::select('file_loads.id','file_loads.nombre',
                                'file_loads.fecha_carga','file_loads.ubicacion')
                ->orderBy('file_loads.created_at', 'desc')
                ->paginate(10);
        return $files;
    }
    
    public static function store($nombre_real,$nombre_carga){
        $file = new FileLoad();
        $file->nombre = $nombre_real;
        $file->ubicacion = $nombre_carga;
        $file->fecha_carga = date('Y-m-d h:m:s');
        $file->estado = 0;
        $file->save();
    }

    public static function getArchivo($id){
        $file = FileLoad::find($id);
        return $file;
    }
}
