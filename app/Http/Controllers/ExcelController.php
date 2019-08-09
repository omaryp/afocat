<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Excel;
use File;
use App\Imports\CertificateImport;
use Illuminate\Support\Facades\Validator;
use App\Rules\FechaValida;

class ExcelController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    //
    public function procesar(){
        $data= request()->all();
        $id = $data['id'];
        $fileLoad = FileLoadController::getArchivo($id);
        $ruta = storage_path('app').'/'.$fileLoad->ubicacion;
        $errores = array();
        try {
            if (File::exists($ruta)){
                $errores = $this->validarExcel($ruta);
                if(sizeof($errores) == 0){
                    $this->cargarExcel($ruta);
                    FileLoadController::updateEstadoProceso($id);
                    return response()->json([
                        'success' => true,
                        'codigo' => 0,
                        'mensaje' => 'Se procesó el excel correctamente !!!',
                    ], 200);     
                }else{
                    $datos['errores'] = $errores;
                    return response()->json([
                        'success' => false,
                        'codigo' => -1,
                        'errores' => View::make('file.error',$datos)->render(),
                    ], 200);
                }
            }else {
                return response()->json([
                    'success' => false,
                    'codigo' => -2,
                    'mensaje' => 'No existe el archivo de excel !!!',
                ], 200);      
            }
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'success' => false,
                'codigo' => -100,
                'mensaje' => 'Error al procesar excel !!!.',
            ], 200);
        }
    }

    public static function validarExcel($ruta){
        $errors = array();
        $fila = 0;
        $excel = Excel::toArray(new CertificateImport, $ruta);
        $filasExcel = $excel[0];
        foreach ($filasExcel as $key => $row) {
            $row['nro_documento'] = str_pad($row['nro_documento'], 8 , "0");   
            $errors[$fila] = ExcelController::validator($row);
            $fila++;
        }
        return $errors;
    }

    public static function validator($data){
        $validator = Validator::make($data, [
            'codigo_certificado' => ['required','string','max:14'],
            'fecha_emision' => ['required',new FechaValida],
            'ini_vigencia' => ['required',new FechaValida],
            'fin_vigencia' => ['required',new FechaValida],
            'ini_control' => ['required',new FechaValida],
            'fin_control' => ['required',new FechaValida],
            'razon_social' => ['required','string'],
            'tipo_documento' => ['required','string','max:3'],
            'nro_documento' => ['required','string','min:8','max:11'],
            'placa' => ['required','string'],
            'provincia' => ['required','string'],
            'categoria' => ['required','string'],
            'uso' => ['required','string'],
            'tipo_vehiculo' => ['required','string'],
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        } 
    }

    public static function cargarExcel($ruta){
        Excel::import(new CertificateImport,$ruta);
    }
}
