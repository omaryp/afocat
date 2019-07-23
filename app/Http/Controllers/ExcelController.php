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
        try {
            if (File::exists($ruta)){
                $this::cargarExcel($ruta);
                FileLoadController::updateEstadoProceso($id);
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Se procesó el excel correctamente !!!',
                ], 200);
            }else {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No existe el archivo de excel !!!',
                ], 200);      
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al procesar el archivo de excel !!!',
            ], 200);
        }
    }

    public static function cargarExcel($ruta){
        Excel::import(new CertificateImport,$ruta);
    }
}
