@extends('adminlte::page')

@section('title', 'Dashboard UTN Osil')

@section('content_header')
  <h1>Organizaciones</h1>
@stop

@section('content')
  <form class="formEdit" action="{{ route('admin.organizaciones.update', $organizacion) }}" method="post">
    @csrf
    @method('put')

    <div class="card">
      <div class="card-header">
        Editar información
      </div>
      <div class="card-body">

        <div class="row p-0 m-0">
          <div class="mb-3 col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $organizacion->nombre) }}">
            @error('nombre')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="pais" class="form-label">País</label>
            <input type="text" class="form-control" id="pais" name="pais" value="{{ old('pais', $organizacion->direccion['pais']) }}">
            @error('pais')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>
  
          <div class="mb-3 col-md-6">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" value="{{ old('estado', $organizacion->direccion['estado']) }}">
            @error('estado')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>
  
          <div class="mb-3 col-md-6">
            <label for="municipio" class="form-label">Municipio</label>
            <input type="text" class="form-control" id="municipio" name="municipio" value="{{ old('municipio', $organizacion->direccion['municipio']) }}">
            @error('municipio')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>
  
          <div class="mb-3 col-md-6">
            <label for="colonia" class="form-label">Colonia</label>
            <input type="text" class="form-control" id="colonia" name="colonia" value="{{ old('colonia', $organizacion->direccion['colonia']) }}">
            @error('colonia')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>
  
          <div class="mb-3 col-md-6">
            <label for="calle" class="form-label">Calle</label>
            <input type="text" class="form-control" id="calle" name="calle" value="{{ old('calle', $organizacion->direccion['calle']) }}">
            @error('calle')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>
  
          <div class="mb-3 col-md-6">
            <label for="numExt" class="form-label">Número exterior</label>
            <input type="text" class="form-control" id="numExt" name="numExt" value="{{ old('numExt', $organizacion->direccion['num_ext']) }}">
            @error('numExt')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>
  
          <div class="mb-3 col-md-6">
            <label for="numInt" class="form-label">Número interior</label>
            <input type="text" class="form-control" id="numInt" name="numInt" value="{{ old('numInt', $organizacion->direccion['num_int']) }}">
            @error('numInt')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="col-md-12">
            <button type="submit" class="btn btn-primary"><i class="fas fa-solid fa-pen"></i> Editar</button>
          </div>
        </div>

      </div>
    </div>

  </form>
@stop

@section('css')
  @viteReactRefresh
  @vite([
    "resources/js/admin/organizaciones.js",
    "resources/css/admin/admin.css",

    'resources/js/librerias/bootstrap.js',
    'resources/css/librerias/bootstrap.css'
  ])
@stop