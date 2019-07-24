@extends('layout')

@section('head_options')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
    <a href="{{ route('users.new') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Nuevo Usuario </a>
</div>
    
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
            <thead>
                <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Ciudad</th>
                <th>esAdministrador</th>
                <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->username}}</td>
                        <td>{{ $user->apellidos }}, {{ $user->nombres }}</td>
                        <td>{{ $user->ciudad}}</td>
                        <td>{{ $user->isAdmin}}</td>
                        <td> 
                            <div class="btn-group mr-2">
                                <a href="{{ route('users.show',['codigo'=> $user->id]) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-fw fa-check-square"></i></a>
                                <a href="{{ route('users.edit',['codigo'=> $user->id]) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-fw fa-pen-square"></i></a>
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
        @include('includes.pagination', ['paginator' => $users])
    </div>
</div>
@endsection

