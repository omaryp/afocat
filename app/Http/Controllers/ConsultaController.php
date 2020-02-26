<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\Parametro;

class ConsultaController extends Controller
{
    //
    public function consulta($placa){
        $certificate = Certificate::select(
                 'certificates.id', 
                 'certificates.codigo_certificado', 
                 'certificates.razon_social',
                 'certificates.ini_vigencia',
                 'certificates.fin_vigencia',
                 'certificates.ini_control', 
                 'certificates.fin_control', 
                 'certificates.placa')
                ->where('certificates.placa','=',$placa)
                ->orderby('created_at','desc')
                ->get()->first();
            if($certificate != null){
                return response()->json([
                    'success' => true,
                    'certificado' => $certificate,
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'certificado' => $certificate,
                    'mensaje' => 'El certificado no existe !!!',
                ], 200);
            }
    }

    public function config(){
        $parametros = Parametro::Select('parametros.codtab','parametros.valent')->where('codigo','=',2)->where('codtab','<>','')->get();
        return response()->json([
            'success' => true,
            'config' => $parametros,
            'mensaje' => 'Datos de configuracion !!!',
        ], 200);
    }   
}
