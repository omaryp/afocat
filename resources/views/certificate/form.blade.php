@extends('layout')

@section('title',"Venta de certificados")


@section('head_options')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Datos Certificado</h1>
  </div>
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
    </div>
    <div class="card-body">
        <form  action=" @if(empty($certificate)) {{ url('certificates') }} @else {{ route('certificates.update',['codigo'=>$certificate->id]) }} @endif" method="POST">
            @unless(empty($certificate)) 
                {{ method_field('PUT') }} 
            @endunless
            {!! csrf_field() !!}

            @if ($errors->any())
                @include('includes.error', ['errors' => $errors])
            @endif
        
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="codigo_certificado" >Número de CAT</label>
                    <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" name = "codigo_certificado" id="codigo_certificado" placeholder="Example YF-001234-2018"
                            @unless(empty($certificate)) value="{{ $certificate->codigo_certificado }}" @else value="{{ old('codigo_certificado') }}" @endunless/>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="fecha_emision">Fecha Emisión</label>
                    <input type="date" @unless($activo) disabled @endunless class="form-control form-control-sm" id="fecha_emision" name ="fecha_emision" placeholder="dd/mm/aaaa" @unless(empty($certificate)) value="{{ $certificate->fecha_emision }}" @else value="{{ old('fecha_emision') }}" @endunless/>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="ini_vigencia">Inicio Vigencia</label>
                    <input type="date" @unless($activo) disabled @endunless class="form-control form-control-sm" id="ini_vigencia" name ="ini_vigencia" placeholder="dd/mm/aaaa" @unless(empty($certificate)) value="{{ $certificate->ini_vigencia }}" @else value="{{ old('ini_vigencia') }}" @endunless/>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="fin_vigencia">Fin Vigencia</label>
                    <input type="date" @unless($activo) disabled @endunless class="form-control form-control-sm" id="fin_vigencia" name ="fin_vigencia" placeholder="dd/mm/aaaa" @unless(empty($certificate)) value="{{ $certificate->fin_vigencia }}" @else value="{{ old('fin_vigencia') }}" @endunless/>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="ini_control">Inicio Control Policial</label>
                    <input type="date" @unless($activo) disabled @endunless class="form-control form-control-sm" id="ini_control" name ="ini_control" placeholder="dd/mm/aaaa" @unless(empty($certificate)) value="{{ $certificate->ini_control }}" @else value="{{ old('ini_control') }}" @endunless/>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="fin_control">Fin Control Policial</label>
                    <input type="date" @unless($activo) disabled @endunless class="form-control form-control-sm" id="fin_control" name ="fin_control" placeholder="dd/mm/aaaa" @unless(empty($certificate)) value="{{ $certificate->fin_control }}" @else value="{{ old('fin_control') }}" @endunless/>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="apellido_paterno">Apellido Paterno del Asociado</label>
                    <div class="input-group">
                        <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="apellido_paterno" name ="apellido_paterno" placeholder="Apellido Paterno" @unless(empty($certificate)) value="{{ $certificate->apellido_paterno }}" @else value="{{ old('apellido_paterno') }}" @endunless/>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="apellido_materno">Apellido Materno del Asociado</label>
                    <div class="input-group">
                        <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="apellido_materno" name ="apellido_materno" placeholder="Apellido Materno" @unless(empty($certificate)) value="{{ $certificate->apellido_materno }}" @else value="{{ old('apellido_materno') }}" @endunless/>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="nombre">Nombre</label>
                    <div class="input-group">
                        <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="nombre" name ="nombre" placeholder="Nombres" @unless(empty($certificate)) value="{{ $certificate->nombre }}" @else value="{{ old('nombre') }}" @endunless/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="razon_social">Razón Social</label>
                    <div class="input-group">
                        <input type="text"  @unless($activo) disabled @endunless class="form-control form-control-sm" id="razon_social" name ="razon_social" placeholder="Razón Social" @unless(empty($certificate)) value="{{ $certificate->razon_social }}" @else value="{{ old('razon_social') }}" @endunless/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="tipo_documento">Tipo Documento</label>
                    <div class="input-group">
                        <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="tipo_documento" name ="tipo_documento" placeholder="Tipo Documento" @unless(empty($certificate)) value="{{ $certificate->tipo_documento }}" @else value="{{ old('tipo_documento') }}" @endunless/>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="nro_documento">Número de Documento</label>
                    <div class="input-group">
                        <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="nro_documento" name ="nro_documento" placeholder="Nro. Documento" @unless(empty($certificate)) value="{{ $certificate->nro_documento }}" @else value="{{ old('nro_documento') }}" @endunless/>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="provincia">Provincia</label>
                    <div class="input-group">
                        <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="provincia" name ="provincia" placeholder="Ejemplo PIURA" @unless(empty($certificate)) value="{{ $certificate->provincia }}" @else value="{{ old('provincia') }}" @endunless/>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="placa">Placa del vehiculo</label>
                    <div class="input-group">
                        <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="placa" name ="placa" placeholder="Placa" @unless(empty($certificate)) value="{{ $certificate->placa }}" @else value="{{ old('placa') }}" @endunless/>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="categoria">Categoría del vehículo</label>
                    <div class="input-group">
                        <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="categoria" name ="categoria" placeholder="Categoría del vehículo" @unless(empty($certificate)) value="{{ $certificate->categoria }}" @else value="{{ old('categoria') }}" @endunless/>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="uso">Uso</label>
                    <div class="input-group">
                        <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="uso" name ="uso" placeholder="Uso del vehículo" @unless(empty($certificate)) value="{{ $certificate->uso }}" @else value="{{ old('uso') }}" @endunless/>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="tipo_vehiculo">Tipo de Vehículo</label>
                    <div class="input-group">
                        <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="tipo_vehiculo" name ="tipo_vehiculo" placeholder="Tipo de vehículo" @unless(empty($certificate)) value="{{ $certificate->tipo_vehiculo }}" @else value="{{ old('tipo_vehiculo') }}" @endunless/>
                    </div>
                </div>           
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="observaciones">Observaciones</label>
                    <div class="input-group">
                        <input type="text"  @unless($activo) disabled @endunless class="form-control form-control-sm" id="observaciones" name ="observaciones" placeholder="Observaciones" @unless(empty($certificate)) value="{{ $certificate->observaciones }}" @else value="{{ old('observaciones') }}" @endunless/>
                    </div>
                </div>
            </div>
            

            @if ($activo)
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button type="submit" class="btn border btn-primary bcertificate">Guardar</button>
                        <a href="{{ route('certificates') }}" class="btn border btn-primary bcertificate">Salir</a>
                    </div>
                </div>    
            @endif
            
        </form>
        @unless ($activo)
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <a href="{{ route('certificates') }}" class="btn border btn-primary bcertificate">Salir</a>
                </div>
            </div>    
        @endunless
    </div>
</div>
@endsection

