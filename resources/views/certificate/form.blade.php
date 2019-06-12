@extends('layout')

@section('title',"Venta de certificados")

@section('title_page')
{{ $title }}
@endsection

@section('content')
    <form  @unless($activo) disabled @endunless action="@if(empty($certificate)) {{ url("certificates") }} @else {{ route('certificates.update',['codigo'=>str_pad($certificate->id,10,'0',STR_PAD_LEFT)]) }} @endif" method="POST">
        @unless(empty($certificate)) 
            {{ method_field('PUT') }} 
        @endunless
        {!! csrf_field() !!}

        @if ($errors->any())
            @include('includes.error', ['errors' => $errors])
        @endif
        
        <input type="hidden" name="numero" @unless(empty($certificate)) value="{{ $certificate->numero }}" @else value="{{ $orden_codigo['numero'] }}"  @endunless/>
        <input type="hidden" name="anio" @unless(empty($certificate)) value="{{ $certificate->anio }}" @else  value="{{ $orden_codigo['anio'] }}" @endunless />
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="codigo" >Código de Orden</label>
                <input type="text" disabled class="form-control form-control-sm" name = "codigo" id="codigo" placeholder="Example 00000012018"
                        @unless(empty($certificate)) value="{{ str_pad($certificate->id,10,'0',STR_PAD_LEFT) }}" @else value="{{ str_pad($orden_codigo['numero'],6,'0',STR_PAD_LEFT).$orden_codigo['anio'] }}" @endunless/>
            </div>
            <div class="col-md-3 mb-3">
                <label for="fecha">Fecha Emisión</label>
                <input type="date" class="form-control form-control-sm" id="fecha_emision" name ="fecha_emision" placeholder="dd/mm/aaaa" @unless(empty($certificate)) value="{{ $certificate->fecha_emision }}" @else value="{{ old('fecha_emision') }}" @endunless/>
            </div>
            <div class="col-md-6 mb-3">
                <label for="proveedor">Proveedor</label>
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <button class="btn btn-primary form-control-sm" type="button" id="btn_buscar">Buscar</button>
                    </div>
                    <input type="text" class="form-control form-control-sm " disabled id="proveedor" name="proveedor" placeholder="Proveedor" @unless(empty($certificate)) value="{{ $certificate->ruc }} - {{ $certificate->razon_social }}" @else value="{{ old('proveedor') }}" @endunless aria-describedby="btn_buscar"/>
                    <input type="hidden" id="proveedor_id" name="proveedor_id" @unless(empty($certificate)) value="{{ $certificate->proveedor_id }}" @else value="{{ old('proveedor_id') }}" @endunless />
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="destino">Destino</label>
                <div class="input-group">
                    @unless(empty($des_recurso))
                        <select name="destino" id="destino" class="form-control form-control-sm" >
                            <option value="0">Seleccionar Destino</option>
                            @foreach ($des_recurso as $des)
                                <option value="{{ $des->codtab }}" @unless(empty($certificate)) @if($certificate->destino == $des->codtab ) selected @endif @else @if(old('destino') == $des->codtab ) selected @endif @endif >{{ $des->descor }}</option>    
                            @endforeach
                        </select>
                    @else
                        <input type="text" class="form-control form-control-sm " value="{{ $certificate->descor }}" />
                    @endunless
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="condicion_pago">Forma de pago</label>
                <div class="input-group">
                    @unless(empty($forma_pago))
                        <select name="condicion_pago" id="condicion_pago" class="form-control form-control-sm">
                            <option value="0">Forma de Pago</option>
                            @foreach ($forma_pago as $forma)
                                <option value="{{ $forma->codtab }}" @unless(empty($certificate)) @if($certificate->condicion_pago == $forma->codtab ) selected @endif @else @if(old('destino') == $forma->codtab ) selected @endif @endif>{{ $forma->descor }}</option>    
                            @endforeach
                        </select>
                    @else
                        <input type="text" class="form-control form-control-sm " value="{{ $certificate->condicion_pago }}" />    
                    @endunless
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="plazo_dias">Plazo de Entrega</label>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" id="plazo_dias" name ="plazo_dias" placeholder="Plazo" @unless(empty($certificate)) value="{{ $certificate->plazo_dias }}" @else value="{{ old('plazo_dias') }}" @endunless/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="almacen">Almacen</label>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" id="almacen" name ="almacen" placeholder="Almacen" @unless(empty($certificate)) value="{{ $certificate->almacen}}" @else value="{{ old('almacen') }}" @endunless/>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="direccion">Dirección</label>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" id="direccion" name ="direccion" placeholder="Dirección" @unless(empty($certificate)) value="{{ $certificate->direccion}}" @else value="{{ old('direccion') }}" @endunless/>
                </div>
            </div>
        </div>

        <div class="row align-items-end ">
            <div class="col-md-11 mb-3">
                    <label for="condiciones">Condiciones de entrega</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" id="condiciones" name ="condiciones_entrega" placeholder="Condiciones de entrega" @unless(empty($certificate)) value="{{ $certificate->condiciones_entrega }}"  @else value="{{ old('condiciones_entrega') }}" @endunless/>
                    </div>
            </div>
            <div class="col-md-1 mb-3">
                <div class="input-group">
                    <button type="button" @if(empty($certificate)) disabled @endif class="btn btn-sm btn-primary" id="btn_detalle">Detalle</button>
                </div>
            </div>
        </div>
        <h1></h1>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="table-responsive">
                    <table class="table table-striped table-sm" id="tabla_detail">
                        <thead>
                            <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @unless(empty($details))
                                @forelse ($details as $det)
                                    <tr>
                                        <td>{{ $det->numero_item }}</td>
                                        <td>{{ $det->cantidad }}</td>
                                        <td>{{ $det->descripcion }}</td>
                                        <td>{{ $det->precio_unitario}}</td>
                                        <td>{{ $det->total }}</td>
                                        <td> 
                                            <a href="" class="sel badge badge-primary">eliminar</a>
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

        @if ($activo)
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button type="submit" class="btn btn-sm btn-primary bcertificate">Guardar</button>
                    <a href="{{ route('certificates') }}" class="btn btn-sm btn-primary bcertificate">Salir</a>
                </div>
            </div>    
        @endif
        
    </form>
    @include('proveedores.search')
    @include('purchasecertificatedetail.form')
    @unless ($activo)
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="{{ route('certificates') }}" class="btn btn-primary bcertificate">Salir</a>
            </div>
        </div>    
    @endunless
@endsection

@section('script')
<script src="{{ asset('js/util.js') }}" ></script>
<script >
    var rpta_srv;
    $(document).ready(function(){
        $( "#proveedor_name" ).keyup(function(e) {
            limpiarTabla();
            searchProveedor($( "#proveedor_name" ).val());
        });

        $( "#cantidad" ).keyup(function(e) {
            var keycode = e.keyCode;
            if(caractesValido(e)){
                $('#total').val(calcularTotal($(this).val(),$('#precio_unitario').val()));
            }
        });

        $( "#precio_unitario" ).keyup(function(e) {
            var keycode = e.keyCode;
            var res = calcularTotal($('#cantidad').val(),$(this).val());
            if(caractesValido(e)){
                $('#total').val(res);
                $('#h_total').val(res);
            }
        });

        $( "#btn_buscar" ).click(function() {
            $( "#proveedor_name" ).val('');
            limpiarTabla();
            $('#md_search').modal('show');
        });

        $( "#btn_detalle" ).click(function() {
            $('#purchase_certificate_id').val($('#codigo').val());
            limpiarformulario();   
            $('#md_detail').modal('show');
        });

        $( "tbody").on("click", "a.sel",function(){
            $( "#proveedor_id" ).val($(this).attr('val_id'));
            $( "#proveedor" ).val($(this).attr('val_ruc')+' - '+$(this).attr('val_razon'));
            $( "#md_search" ).modal('hide');
        });

        $("#frm_detail").submit(function(){
            ajax_post($("#frm_detail").attr('action'),$("#frm_detail").serialize());
            return false;
        });
    });


    function caractesValido(e){
        return true;
    }

    function searchProveedor(valor){
        ajax_get("{{ url('proveedores/search') }}",valor);
    }

    function calcularTotal(cant,precio){
        if(cant=='') cant = 0 ;
        if(precio=='') precio = 0 ;
        return parseFloat(cant)*parseFloat(precio);
    }

    function ajax_get(ruta,data){
        $.getJSON( ruta+='/'+data , {_token: '{!! csrf_token() !!}'})
        .done(function( data, textStatus, jqXHR ) {
            data.forEach(prov => {
                $("#tabla_prov tbody" ).append(
                    '<tr> <td> '+prov.id+'</td>'+
                    '<td> '+prov.ruc+'</td> '+ 
                    '<td>'+prov.razon_social+'</td>'+
                    '<td> <a class="sel badge badge-primary" href="#" val_ruc = "'+prov.ruc+'" val_id="'+prov.id+'" val_razon="'+prov.razon_social+'" >Seleccionar</a></td>'+
                    '</tr>');
            });
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "Algo ha fallado: " +  textStatus);
            }
        });
    }   


    function procesar_rpta(rpta){
        $('#error').addClass('d-none');
        if(rpta.success){
            $("#tabla_detail tbody" ).append(
                '<tr> <td> '+rpta.id+'</td>'+
                '<td> '+$('#cantidad').val()+'</td> '+ 
                '<td>'+$('#descripcion').val()+'</td>'+
                '<td>'+$('#precio_unitario').val()+'</td>'+
                '<td>'+$('#total').val()+'</td>'+
                '<td> <a class="sel badge badge-primary" href="#" id_item = "'+rpta.id+'" val_po="'+$('#purchase_certificate_id').val()+'" >Eliminar</a></td>'+
                '</tr>');
        }   
        else{
            mensajes =  rpta.mensajes;
            $('#error').removeClass('d-none');
            mensajes.forEach(err => {
                $('#error ul').append('<li>'+err+'</li>');
            });
        }
    }

    function limpiarTabla(){
        $("#tabla_prov tbody tr" ).remove();
    }

    function limpiarformulario(){
        $("#cantidad" ).val('');
        $("#unidad_medida" ).val('');
        $("#descripcion" ).val('');
        $("#precio_unitario" ).val('');
        $("#total" ).val('');
        $('#error').addClass('d-none');
        $("#tabla_prov tbody tr" ).remove();
    }
    
</script>
@endsection