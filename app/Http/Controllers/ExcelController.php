<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use File;
use App\Imports\CertificateImport;

class ExcelController extends Controller
{
    //
    public function procesar(){
        $data= request()->all();
        $id = $data['id'];
        $fileLoad = FileLoadController::getArchivo($id);
        $ruta = storage_path('app').'/'.$fileLoad->ubicacion;
        if (File::exists($ruta)){
            $this::cargarExcel($ruta);
        }else {
            $mensaje = "No existe el archivo";      
        }
    }

    public static function cargarExcel($ruta){
        Excel::import(new CertificateImport,$ruta);
    }
}
