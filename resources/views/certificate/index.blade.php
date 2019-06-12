@extends('layout')

@section('title_page')
{{ $title }}
@endsection

@section('head_options')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Certificados</h1>
    <a href="{{ route('certificates.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Nuevo Certificado </a>
  </div>
    
@endsection

@section('content')
    
        <div class="table-responsive">
            <table class="table table-striped table-sm">
            <thead>
                <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Placa</th>
                <th>Inicio Vigencia</th>
                <th>Fin Vigencia</th>
                <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                    @forelse ($certificates as $cert)
                    <tr>
                        <td>{{ $cert->codigo_certificado }}</td>
                        <td>{{ $cert->nombre }} {{ $cert->apellido_paterno }} {{ $cert->apellido_materno }}</td>
                        <td>{{ $cert->placa }}</td>
                        <td>{{ $cert->ini_vigencia}}</td>
                        <td>{{ $cert->fin_vigencia}}</td>
                        <td> 
                            <div class="btn-group mr-2">
                                <a href="{{ route('certificates.show',['codigo'=> $cert->id]) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-fw fa-check-square"></i></a>
                                <a href="{{ route('certificates.edit',['codigo'=> $cert->id]) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-fw fa-pen-square"></i></a>
                                <a class="btn btn-outline-secondary btn-sm"><i class="fas fa-fw fa-trash-alt"></i></a>
                            </div>
                        </td>   
                    </tr>
                @empty 
                    <tr>    
                        <td colspan="6">
                            <h6>No se encontraron elementos.</h6>
                        </td>
                    </tr>
                @endforelse       
            </tbody>
            </table>
        </div>
        @include('includes.pagination', ['paginator' => $certificates])
@endsection

