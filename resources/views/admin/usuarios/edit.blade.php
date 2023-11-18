@extends('adminlte::page')

@section('title', 'Dashboard UTN Osil')

@section('content_header')
  <h1>Usuarios</h1>
@stop

@section('content')
  <form class="formEdit" action="{{ route('admin.usuarios.update', $usuario) }}" method="post">
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
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}">
            @error('nombre')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="matricula" class="form-label">Matrícula</label>
            <input type="text" class="form-control" id="matricula" name="matricula" value="{{ old('matricula', $usuario->matricula) }}">
            @error('matricula')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo', $usuario->correo) }}">
            @error('correo')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="tipo_usuario" class="form-label">Tipo de usuario</label>
            <select class="form-select" aria-label="Default select example" id="tipo_usuario" name="tipo_usuario">
              @foreach($tipos_usuario as $tipo_usuario)
                <option value="{{ $tipo_usuario->id }}" {{ $usuario->id_tipo_usuario == $tipo_usuario->id ? 'selected' : '' }}>
                  {{ $tipo_usuario->nombre }}
                </option>
              @endforeach
            </select>
            @error('tipo_usuario')
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