@extends('layouts.app')

@section('content')
<div class="container">
<form action="{{ url('/empleado/'.$empleado->id ) }}" method="post" enctype="multipart/form-data">
    @csrf
    {{ @method_field('PATCH') }}
    <div class="form-group">
        <label for="Nombre">Nombre</label>
        <input type="text" class="form-control" name="Nombre" id="Nombre" value="{{ isset($empleado->Nombre)?$empleado->Nombre:old('Nombre') }}">
    </div>

    <div class="form-group">
        <label for="ApellidoPaterno">Apellido paterno</label>
        <input class="form-control" type="text" name="ApellidoPaterno" id="ApellidoPaterno" value="{{ isset($empleado->ApellidoPaterno)?$empleado->ApellidoPaterno:old('ApellidoPaterno') }}">
    </div>

    <div class="form-group">
        <label for="ApellidoMaterno">Apellido materno</label>
        <input class="form-control" type="text" name="ApellidoMaterno" id="ApellidoMaterno" value="{{ isset($empleado->ApellidoMaterno)?$empleado->ApellidoMaterno:old('ApellidoMaterno') }}">
    </div>
    
    <div class="form-group">
        <label for="Correo">Correo</label>
        <input class="form-control" type="text" name="Correo" id="Correo" value="{{ isset($empleado->Correo)?$empleado->Correo:old('Correo') }}">
    </div>
    <div class="form-group">
        <label for="Rut">Rut (11.111.111-1)</label>
        <input class="form-control" type="text" name="Rut" id="Rut" value="{{ isset($empleado->Rut)?$empleado->Rut:old('Rut') }}">
    </div>
    <br>
    <div class="form-group">
        <select class="form-select" aria-label="Default select example" id="TipoMembresia" name="TipoMembresia">
            <option>Tipo de membresía</option>
            <option value="Diario">Diario (1.000)</option>
            <option value="Mensual">Mensual (2.000)</option>
            <option value="Trimestral">Trimestral (3.000)</option>
            <option value="Semestral">Semestral (4.000)</option>
            <option value="Anual">Anual (5.000)</option>
        </select>
    </div>

    <div class="form-group">
        <label for="Foto"></label>

        <input class="form-control" type="file" name="Foto" id="Foto" value="">
        @if(isset($empleado->Foto))
        <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$empleado->Foto }}" width="100" alt="">
        @endif
    </div>
    <br>
    <input class="btn btn-success" type="submit">
    <a class="btn btn-primary" href="{{ url('empleado/') }}">Volver</a>
</form>
</div>
@endsection