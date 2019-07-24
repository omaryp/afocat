<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;

class CertificateController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('guest',['only'=>'consulta']);
    }

    public function index(){
        $certificates = Certificate::
             select('certificates.id', 
                    'certificates.codigo_certificado',
                    'certificates.ini_vigencia',
                    'certificates.fin_vigencia',
                    'certificates.apellido_paterno', 
                    'certificates.apellido_materno',
                    'certificates.tipo_documento',
                    'certificates.nombre',
                    'certificates.placa')
                ->orderBy('certificates.codigo_certificado', 'asc')
                ->paginate(10);
        $title = 'Listado de Ventas de Certificados';  
        //dd($certificates);
        return view('certificate.index',compact('certificates','title'));
    }

    public function create(){
        $title = 'Nueva Venta de Certificado';
        $activo = TRUE;
        $datos_vista = compact('activo','title');
        return view('certificate.form',$datos_vista);
    }

    public function store(){
        $data = request()->validate([
            'codigo_certificado'=>'required|size:14|unique',
            'ini_vigencia'=>'required|date_format:Y-m-d',
            'fin_vigencia'=>'required|date_format:Y-m-d', 
            'ini_control'=>'required|date_format:Y-m-d',
            'fin_control' => 'required|date_format:Y-m-d',
            'apellido_paterno' => 'nullable',
            'apellido_materno' => 'nullable',
            'nombre' => 'nullable',
            'razon_social' => 'nullable',
            'tipo_documento' => 'nullable',
            'nro_documento' => 'required|numeric|between:8,11',
            'placa' => 'required',
            'provincia' => 'required|string',
            'categoria' => 'required',
            'uso' => 'required',
            'tipo_vehiculo' => 'required',
            'fecha_emision' => 'required|date_format:Y-m-d', 
        ]);
            
        $cert = new Certificate();
        $clave = explode("-",$data['codigo_certificado']);
        $cert->numero=$clave[1];
        $cert->anio=$clave[2];
        $cert->codigo_certificado = $data['codigo_certificado'];
        $cert->ini_vigencia=date_format(date_create($data['ini_vigencia']), 'Y-m-d H:i:s');
        $cert->fin_vigencia=date_format(date_create($data['fin_vigencia']), 'Y-m-d H:i:s');
        $cert->ini_control=date_format(date_create($data['ini_control']), 'Y-m-d H:i:s');
        $cert->fin_control=date_format(date_create($data['fin_control']), 'Y-m-d H:i:s');
        $cert->apellido_paterno=$data['apellido_paterno'];
        $cert->apellido_materno=$data['apellido_materno'];
        $cert->nombre=$data['nombre'];
        $cert->tipo_documento=$data['tipo_documento'];
        $cert->nro_documento=$data['nro_documento'];
        $cert->placa=$data['placa'];
        $cert->provincia=$data['provincia'];
        $cert->categoria=$data['categoria'];
        $cert->uso=$data['uso'];
        $cert->tipo_vehiculo=$data['tipo_vehiculo'];
        $cert->fecha_emision=$data['fecha_emision'];
        $cert->save();
        return redirect()->route('certificate.edit',['codigo' => $cert->id]);
    }

    public function show($codigo){
        $certificate = Certificate::select(
                 'certificates.id', 
                 'certificates.codigo_certificado', 
                 'certificates.ini_vigencia',
                 'certificates.fin_vigencia',
                 'certificates.ini_control', 
                 'certificates.fin_control',
                 'certificates.apellido_paterno',
                 'certificates.apellido_materno',
                 'certificates.nombre',
                 'certificates.razon_social',
                 'certificates.tipo_documento',
                 'certificates.nro_documento', 
                 'certificates.placa',
                 'certificates.provincia',
                 'certificates.categoria',
                 'certificates.uso',
                 'certificates.tipo_vehiculo',
                 'certificates.fecha_emision')
                ->where('certificates.id','=',$codigo)
                ->get()->first();
        $certificate->ini_vigencia = date_format(date_create($certificate->ini_vigencia), 'Y-m-d');
        $certificate->fin_vigencia = date_format(date_create($certificate->fin_vigencia), 'Y-m-d');
        $certificate->ini_control = date_format(date_create($certificate->ini_control), 'Y-m-d');
        $certificate->fin_control = date_format(date_create($certificate->fin_control), 'Y-m-d');
        $certificate->fecha_emision=date_format(date_create($certificate->fecha_emision), 'Y-m-d');
        $title = 'Consulta Certificado';
        $activo = FALSE;
        return view('certificate.form',compact('certificate','activo','title'));
    }

    public function edit($codigo){
        $certificate = Certificate::select(
            'certificates.id', 
            'certificates.codigo_certificado', 
            'certificates.ini_vigencia',
            'certificates.fin_vigencia',
            'certificates.ini_control', 
            'certificates.fin_control',
            'certificates.apellido_paterno',
            'certificates.apellido_materno',
            'certificates.nombre',
            'certificates.razon_social',
            'certificates.tipo_documento',
            'certificates.nro_documento', 
            'certificates.placa',
            'certificates.provincia',
            'certificates.categoria',
            'certificates.uso',
            'certificates.tipo_vehiculo',
            'certificates.fecha_emision')
           ->where('certificates.id','=',$codigo)
           ->get()->first();
        $certificate->ini_vigencia = date_format(date_create($certificate->ini_vigencia), 'Y-m-d');
        $certificate->fin_vigencia = date_format(date_create($certificate->fin_vigencia), 'Y-m-d');
        $certificate->ini_control = date_format(date_create($certificate->ini_control), 'Y-m-d');
        $certificate->fin_control = date_format(date_create($certificate->fin_control), 'Y-m-d');
        $title = 'Actualizar Certificado';
        $activo = TRUE;
        $datos_vista = compact('activo','title','certificate');
        return view('certificate.form',$datos_vista);
    }

    public function update($codigo){
        $data = request()->validate([
            'codigo_certificado'=>'required|size:14|unique',
            'ini_vigencia'=>'required|date_format:Y-m-d',
            'fin_vigencia'=>'required|date_format:Y-m-d', 
            'ini_control'=>'required|date_format:Y-m-d',
            'fin_control' => 'required|date_format:Y-m-d',
            'apellido_paterno' => 'nullable',
            'apellido_materno' => 'nullable',
            'nombre' => 'nullable',
            'razon_social' => 'nullable',
            'tipo_documento' => 'nullable',
            'nro_documento' => 'required|numeric|between:8,11',
            'placa' => 'required',
            'provincia' => 'required|string',
            'categoria' => 'required',
            'uso' => 'required',
            'tipo_vehiculo' => 'required',
            'fecha_emision' => 'required|date_format:Y-m-d', 
        ]);   
        $cert=Certificate::where('id','=',$codigo)->get()->first();
        $cert->update($data);
        return redirect()->route('certificates.edit',['codigo' =>$codigo]);
    }

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
