<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;

class CertificateController extends Controller
{
    //

    public function index(){
        $certificates = Certificate::
             select('certificates.id', 
                    'certificates.codigo_certificado',
                    'certificates.ini_vigencia',
                    'certificates.fin_vigencia',
                    'certificates.apellido_paterno', 
                    'certificates.apellido_materno',
                    'certificates.nombre',
                    'certificates.placa')
                ->orderBy('certificates.created_at', 'desc')
                ->paginate(7);
        $title = 'Listado de Ventas de Certificados';  
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
        $cert = Certificate::select(
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
        $cert->ini_vigencia = date_format(date_create($order->ini_vigencia), 'Y-m-d');
        $cert->fin_vigencia = date_format(date_create($order->fin_vigencia), 'Y-m-d');
        $cert->ini_control = date_format(date_create($order->ini_control), 'Y-m-d');
        $cert->fin_control = date_format(date_create($order->fin_control), 'Y-m-d');
        $cert->fecha_emision=date_format(date_create($order->fecha_emision), 'Y-m-d');
        $title = 'Consulta Certificado';
        $activo = FALSE;
        return view('certificate.form',compact('cert','activo','title'));
    }

    public function edit($codigo){
        $cert = Certificate::select(
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
        $cert->ini_vigencia = date_format(date_create($order->ini_vigencia), 'Y-m-d');
        $cert->fin_vigencia = date_format(date_create($order->fin_vigencia), 'Y-m-d');
        $cert->ini_control = date_format(date_create($order->ini_control), 'Y-m-d');
        $cert->fin_control = date_format(date_create($order->fin_control), 'Y-m-d');
        $title = 'Actualizar Certificado';
        $activo = TRUE;
        $datos_vista = compact('activo','title','cert');
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
}
