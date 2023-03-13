@extends('layouts.app')

@section('content')
<div class="container">

@if(Session::has('mensaje'))
{{ Session::get('mensaje') }}
@endif
<a href="{{ url('empleado/create') }}" class="btn btn-success">Agregar empleado</a>
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
    </tbody>
</table>
<div class="card-body">
{{$empleados->links()}}
</div>
</div>
@endsection