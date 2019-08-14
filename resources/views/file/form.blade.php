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
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
    </div>
    <div class="card-body">
    <form method="POST" action="{{ url('load') }}" accept-charset="UTF-8" enctype="multipart/form-data">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @if ($errors->any())
            @include('includes.error', ['errors' => $errors])
        @endif
        <div class="row">
            <div class="col-md-10 mb-3">
                <div class="input-group mb-3">
                    <input type="file" name="archivo"  id="archivo" class="from-control form-control-sm" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button type="submit" class="btn btn-sm btn-primary brequest"><i class="fas fa-fw fa-file-upload"></i> Subir Archivo</button>
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
                                                <div class="load btn" ></div>
                                                <button type="button" codigo="{{ $file->id }}" class="eliminar btn btn-outline-secondary btn-sm @if($file->estado != 0) d-none @endif"><i class="fas fa-fw fa-trash-alt"></i></button>
                                                <button type="button" codigo="{{ $file->id }}" class="procesar btn btn-outline-secondary btn-sm @if($file->estado != 0) d-none @endif"><i class="fas fa-fw fa-play-circle"></i></button>
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
</div>
</div>



<div class="modal fade" id="erroresExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Validación Excel</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div id ="errores">
                
            </div>
                        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/util.js') }}" ></script>
<script >
    var rpta_srv;
    $(document).ready(function(){

        $( "tbody").on("click", "button.eliminar",function(){
            eliminarArchivo($(this).attr('codigo'));
        });

        $( "tbody").on("click", "button.procesar",function(){
            $("tbody div.load").html('<img src="{{ asset('images/load.gif') }}"/>');
            procesarArchivo($(this).attr('codigo'));
        });

    });

    function procesarArchivo(codigo){
        ajax_post('{{ url('excel') }}',{id: codigo,_token: '{!! csrf_token() !!}'})
    }

    function eliminarArchivo(codigo){
        ajax_delete( '{{ url('storage') }}/'+codigo,{_token: '{!! csrf_token() !!}'});
    }

    function procesar_rpta(rpta){
        $("tbody div.load").empty();
        switch (rpta.codigo) {
            case -1:
                $('#errores').empty();
                $('#errores').html(rpta.errores);
                $('#erroresExcel').modal('show');
                break;
            default :
                alert(rpta.mensaje);
                window.location="{{ url('storage') }}";
                break;
        }
    }

</script>
@endsection