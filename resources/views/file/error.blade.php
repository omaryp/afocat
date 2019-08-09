<div class="alert alert-danger">
    Por favor elimine el archivo, corrija los errores y vuelva a subir el archivo.
</div>
@foreach ($errores as $errorfila)
    @if($errorfila != null)
        <div class="alert alert-danger">
            <div>La fila {{ $loop->index }} del excel cargado presenta los siguientes errores : </div>
            <ul>
                @foreach ($errorfila as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>  
        </div>
    @endIf
@endforeach