@extends('layout')
 
@section('title_page')
{{ $title }}
@endsection

@section('head_options')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Archivos</h1>
    
  </div>
    
@endsection

@section('content')
    <form method="POST" action="{{ url('load') }}" accept-charset="UTF-8" enctype="multipart/form-data">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
               <!-- <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">Carga</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" value="" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">Seleccionar Archivo</label>
                    </div>
                </div>-->
        </div>
        <div class="row">
            <div class="col-md-10 mb-3">
                <div class="input-group mb-3">
                    <input type="file" name="carga"  id="carga" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button type="submit" class="btn btn-sm btn-primary brequest">Subir</button>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="tabla_erdetail">
                            <thead>
                                <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Nombre Archivo</th>
                                <th scope="col">Fecha de Carga</th>
                                <th scope="col">Ubicacion</th>
                                <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @unless(empty($files))
                                    @forelse ($files as $file)
                                        <tr @if($file->estado == 0) class="table-danger" @else class="table-success" @endif>
                                            <td>{{ $file->id }}</td>
                                            <td>{{ $file->nombre }}</td>
                                            <td>{{ $file->fecha_carga }}</td>
                                            <td>{{ $file->ubicacion }}</td>
                                            <td> 
                                                    <a href="" class="btn btn-outline-secondary btn-sm"><i class="fas fa-fw fa-trash-alt"></i></a>
                                                    <a href="" class="btn btn-outline-secondary btn-sm @if($file->estado != 0) d-none @endif"><i class="fas fa-fw fa-play-circle"></i></a>
                                            </td>   
                                        </tr>
                                    @empty 
                                        <tr>    
                                            <td colspan="6">
                                                <h6>No se ha registrado items.</h6>
                                            </td>
                                        </tr>
                                    @endforelse            
                                @else
                                    <tr>    
                                        <td colspan="6">
                                            <h6>No se ha registrado items.</h6>
                                        </td>
                                    </tr>
                                @endunless                      
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </form>
    @include('includes.pagination', ['paginator' => $files])
@endsection