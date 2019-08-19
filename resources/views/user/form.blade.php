@extends('layout')

@section('title',"Venta de certificados")


@section('head_options')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Datos Usuarios</h1>
  </div>
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
    </div>
    <div class="card-body">
        <form  action=" @if(empty($user)) {{ url('users') }} @else {{ route('users.update',['codigo'=>$user->id]) }} @endif" method="POST">
            @unless(empty($user)) 
                {{ method_field('PUT') }} 
            @endunless
            {!! csrf_field() !!}

            @if ($errors->any())
                @include('includes.error', ['errors' => $errors])
            @endif
        
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="username" >Usuario</label>
                    <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" name = "username" id="username" placeholder="Example omanpe"
                            @unless(empty($user)) value="{{ $user->username }}" @else value="{{ old('username') }}" @endunless/>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombres">Nombres</label>
                    <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="nombres" name ="nombres" placeholder="Ingrese Nombres" @unless(empty($user)) value="{{ $user->nombres }}" @else value="{{ old('nombres') }}" @endunless/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="apellidos" name ="apellidos" placeholder="Ingrese Apellidos" @unless(empty($user)) value="{{ $user->apellidos }}" @else value="{{ old('apellidos') }}" @endunless/>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-group">
                        <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm" id="email" name ="email" placeholder="Por ejemplo example@afocat.com.pe" @unless(empty($user)) value="{{ $user->email }}" @else value="{{ old('email') }}" @endunless/>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ciudad">Ciudad</label>
                    <div class="input-group">
                        @unless(empty($ciudades))
                            <select name="ciudad" id="ciudad" class="form-control form-control-sm" >
                                <option value="0">Seleccionar Ciudad</option>
                                @foreach ($ciudades as $des)
                                    <option value="{{ $des->codtab }}" @unless(empty($user)) @if($user->ciudad == $des->codtab ) selected @endif @else @if(old('ciudad') == $des->codtab ) selected @endif @endif >{{ $des->descor }}</option>    
                                @endforeach
                            </select>
                        @else
                            <input type="text" @unless($activo) disabled @endunless class="form-control form-control-sm " value="{{ $user->descor }}" />
                        @endunless
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password">Contraseña</label>
                    <div class="input-group">
                        <input type="password" @unless($activo) disabled @endunless class="form-control form-control-sm" id="password" name ="password" placeholder="Contraseña" @unless(empty($user)) value="{{ $user->password }}" @else value="{{ old('password') }}" @endunless/>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cpassword">Confirmar Contraseña</label>
                    <div class="input-group">
                        <input type="password" @unless($activo) disabled @endunless class="form-control form-control-sm" id="cpassword" name ="cpassword" placeholder="Confirmar Contraseña" @unless(empty($user)) value="{{ $user->password }}" @else value="{{ old('cpassword') }}" @endunless/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="">Opciones</label>
                </div>
            </div>
            <div class="row">
                @foreach ($opciones_guardar as $opc)
                    <div class="col-md-4 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" @if($opc->activo == 1 ) checked @endif value="{{ $opc->codigo }}" id="{{ $opc->codigo }}">
                            <label class="form-check-label" for="defaultCheck1">
                                    {{ $opc->descripcion }}
                            </label>
                        </div>
                    </div>
                    @if ($opc->codigo % 3 == 0)
                        </div>
                        <div class="row">
                    @endif                    
                @endforeach
            </div>
                    
            @if ($activo)
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button type="submit" class="btn border btn-primary buser">Guardar</button>
                        <a href="{{ route('users') }}" class="btn border btn-primary buser">Salir</a>
                    </div>
                </div>    
            @endif
            
        </form>
        @unless ($activo)
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <a href="{{ route('users') }}" class="btn border btn-primary buser">Salir</a>
                </div>
            </div>    
        @endunless
    </div>
</div>
@endsection

