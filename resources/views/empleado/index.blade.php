@extends('layouts.app')

@section('content')
<div class="container">
<a href="{{url('empleado/create')}}" class="btn btn-success">Agregar miembro</a>

<form action="{{route('empleado.index')}}" method="get">
    <div class="form row">
        <div class="col-sm-4 my-1">
            <input type="text" class="form-control" name="texto" value="{{$texto}}">
        </div>
        <div class="col-auto my-1">
            <input type="submit" class="btn btn-primary" value="Buscar">
        </div>
    </div>
</form>

@if(Session::has('mensaje'))
{{ Session::get('mensaje') }}
@endif
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>A.Paterno</th>
            <th>A.Materno</th>
            <th>Correo</th>
            <th>Membresia</th>
            <th>Acciones</th>
        </tr>
    </thead>
    
    <tbody>
        @if(count($empleados)<=0)
            <tr>
                <td colspan="8">No se encontraron resultados</td>
            </tr>
        @else
        @foreach($empleados as $empleado)
        <tr>
            <td>{{ $empleado->id }}</td>
            <td>
                <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$empleado->Foto }}" width="100" alt="">
            </td>
            <td>{{ $empleado->Nombre }}</td>
            <td>{{ $empleado->ApellidoPaterno }}</td>
            <td>{{ $empleado->ApellidoMaterno }}</td>
            <td>{{ $empleado->Correo }}</td>
            <td>{{ $empleado->TipoMembresia }}</td>
            <td>
                <a href="{{ url('/empleado/'.$empleado->id.'/edit') }}" class="btn btn-warning">
                    Editar
                </a>
                |
                <form action="{{ url('/empleado/'.$empleado->id) }}" method="POST" class="d-inline">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input class="btn btn-danger" type="submit" onclick="return confirm('¿Quieres borrar?')" 
                    value="Borrar">
                </form>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{$empleados->links()}}
</div>
@endsection