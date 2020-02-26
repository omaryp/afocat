<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;

class CertificateController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $datos = $this->listarTodo();
        return view('certificate.index',$datos);
    }

    public function listarTodo(){
        $certificates = Certificate::
            select('certificates.id', 
                   'certificates.codigo_certificado',
                   'certificates.ini_vigencia',
                   'certificates.fin_vigencia',
                   'certificates.razon_social',
                   'certificates.tipo_documento',
                   'certificates.placa')
               ->orderBy('certificates.codigo_certificado', 'asc')
               ->paginate(10);
       $title = 'Listado de Ventas de Certificados';  
       $opciones = MenuController::getMenu(auth()->user()->id);
       return compact('certificates','title','opciones');
    }

    public function create(){
        $title = 'Nueva Venta de Certificado';
        $activo = TRUE;
        $opciones = MenuController::getMenu(auth()->user()->id);
        $datos_vista = compact('activo','title','opciones');
        return view('certificate.form',$datos_vista);
    }

    public function store(){
        $data = request()->validate([
            'codigo_certificado'=>'required|size:11|unique:certificates,codigo_certificado',
            'ini_vigencia'=>'required|date_format:Y-m-d',
            'fin_vigencia'=>'required|date_format:Y-m-d', 
            'ini_control'=>'required|date_format:Y-m-d',
            'fin_control' => 'required|date_format:Y-m-d',
            'razon_social' => 'required',
            'tipo_documento' => 'required',
            'nro_documento' => 'required|numeric|digits_between:8,11',
            'placa' => 'required',
            'provincia' => 'required|string',
            'categoria' => 'required',
            'uso' => 'required',
            'tipo_vehiculo' => 'required',
            'fecha_emision' => 'required|date_format:Y-m-d', 
            'observaciones' => 'nullable',
        ]);
        $cert = new Certificate();
        $clave = explode("-",$data['codigo_certificado']);
        $cert->correlativo=$clave[0];
        $cert->anio=$clave[1];
        $cert->codigo_certificado = $data['codigo_certificado'];
        $cert->ini_vigencia=date_format(date_create($data['ini_vigencia']), 'Y-m-d H:i:s');
        $cert->fin_vigencia=date_format(date_create($data['fin_vigencia']), 'Y-m-d H:i:s');
        $cert->ini_control=date_format(date_create($data['ini_control']), 'Y-m-d H:i:s');
        $cert->fin_control=date_format(date_create($data['fin_control']), 'Y-m-d H:i:s');
        $cert->razon_social=$data['razon_social'];
        $cert->tipo_documento=$data['tipo_documento'];
        $cert->nro_documento=$data['nro_documento'];
        $cert->placa=$data['placa'];
        $cert->provincia=$data['provincia'];
        $cert->categoria=$data['categoria'];
        $cert->uso=$data['uso'];
        $cert->tipo_vehiculo=$data['tipo_vehiculo'];
        $cert->fecha_emision=$data['fecha_emision'];
        $cert->save();
        return redirect()->route('certificates.edit',['codigo' => $cert->id]);
    }

    public function show($codigo){
        $certificate = Certificate::select(
                 'certificates.id', 
                 'certificates.codigo_certificado', 
                 'certificates.ini_vigencia',
                 'certificates.fin_vigencia',
                 'certificates.ini_control', 
                 'certificates.fin_control',
                 'certificates.razon_social',
                 'certificates.tipo_documento',
                 'certificates.nro_documento', 
                 'certificates.placa',
                 'certificates.provincia',
                 'certificates.categoria',
                 'certificates.uso',
                 'certificates.tipo_vehiculo',
                 'certificates.fecha_emision',
                 'certificates.observaciones')
                ->where('certificates.id','=',$codigo)
                ->get()->first();
        $certificate->ini_vigencia = date_format(date_create($certificate->ini_vigencia), 'Y-m-d');
        $certificate->fin_vigencia = date_format(date_create($certificate->fin_vigencia), 'Y-m-d');
        $certificate->ini_control = date_format(date_create($certificate->ini_control), 'Y-m-d');
        $certificate->fin_control = date_format(date_create($certificate->fin_control), 'Y-m-d');
        $certificate->fecha_emision=date_format(date_create($certificate->fecha_emision), 'Y-m-d');
        $title = 'Consulta Certificado';
        $activo = FALSE;
        $opciones = MenuController::getMenu(auth()->user()->id);
        return view('certificate.form',compact('certificate','activo','title','opciones'));
    }

    public function search(){
        $certificates = NULL;
        $data = request()->all();
        $busqueda = $data['cmbBusqueda'];
        $dato = $data['dato_busqueda'];
        switch ($busqueda) {
            case '1':
                $certificates = Certificate::
                    select('certificates.id', 
                           'certificates.codigo_certificado',
                           'certificates.ini_vigencia',
                           'certificates.fin_vigencia',
                           'certificates.razon_social',
                           'certificates.tipo_documento',
                           'certificates.placa')
                    ->where('certificates.placa','like',$dato."%")
                    ->paginate(10);
                break;
            case '2':
                $certificates = Certificate::
                select('certificates.id', 
                       'certificates.codigo_certificado',
                       'certificates.ini_vigencia',
                       'certificates.fin_vigencia',
                       'certificates.razon_social',
                       'certificates.tipo_documento',
                       'certificates.placa')
                ->where('certificates.codigo_certificado','like',$dato."%")
                ->paginate(10);
                break;
        }
        $title = 'Listado de Ventas de Certificados';  
        $opciones = MenuController::getMenu(auth()->user()->id);
        return view('certificate.index',compact('certificates','title','opciones'));
    }

    public function edit($codigo){
        $certificate = Certificate::select(
            'certificates.id', 
            'certificates.codigo_certificado', 
            'certificates.ini_vigencia',
            'certificates.fin_vigencia',
            'certificates.ini_control', 
            'certificates.fin_control',
            'certificates.razon_social',
            'certificates.tipo_documento',
            'certificates.nro_documento', 
            'certificates.placa',
            'certificates.provincia',
            'certificates.categoria',
            'certificates.uso',
            'certificates.tipo_vehiculo',
            'certificates.fecha_emision',
            'certificates.observaciones')
           ->where('certificates.id','=',$codigo)
           ->get()->first();
        $certificate->ini_vigencia = date_format(date_create($certificate->ini_vigencia), 'Y-m-d');
        $certificate->fin_vigencia = date_format(date_create($certificate->fin_vigencia), 'Y-m-d');
        $certificate->ini_control = date_format(date_create($certificate->ini_control), 'Y-m-d');
        $certificate->fin_control = date_format(date_create($certificate->fin_control), 'Y-m-d');
        $title = 'Actualizar Certificado';
        $activo = TRUE;
        $opciones = MenuController::getMenu(auth()->user()->id);
        $datos_vista = compact('activo','title','certificate','opciones');
        return view('certificate.form',$datos_vista);
    }

    public function delete($codigo){
        Certificate::where('certificates.id','=',$codigo)->delete();
        $datos = $this->listarTodo();
        return view('certificate.index',$datos);
    }

    public function update($codigo){
        $data = request()->validate([
            'codigo_certificado'=>'string|required|size:11',
            'ini_vigencia'=>'required|date_format:Y-m-d',
            'fin_vigencia'=>'required|date_format:Y-m-d', 
            'ini_control'=>'required|date_format:Y-m-d',
            'fin_control' => 'required|date_format:Y-m-d',
            'razon_social' => 'required',
            'tipo_documento' => 'nullable',
            'nro_documento' => 'required|string|digits_between:8,11',
            'placa' => 'required',
            'provincia' => 'required|string',
            'categoria' => 'required',
            'uso' => 'required',
            'tipo_vehiculo' => 'required',
            'fecha_emision' => 'required|date_format:Y-m-d',
            'observaciones' => 'nullable', 
        ]);   
        $cert=Certificate::where('id','=',$codigo)->get()->first();
        $cert->update($data);
        return redirect()->route('certificates.edit',['codigo' =>$codigo]);
    }
}
