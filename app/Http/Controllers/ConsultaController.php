<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;

class ConsultaController extends Controller
{
    //
    public function consulta($placa){
        $certificate = Certificate::select(
                 'certificates.id', 
                 'certificates.codigo_certificado', 
                 'certificates.ini_vigencia',
                 'certificates.fin_vigencia',
                 'certificates.ini_control', 
                 'certificates.fin_control', 
                 'certificates.placa')
                ->where('certificates.placa','=',$placa)
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
}
