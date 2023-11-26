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
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo', $usuario->correo) }}">
            @error('correo')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-12">
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

          <div class="mb-3 col-md-12">
            <div class="row">
              <div class="mb-3 col-sm-6 col-md-3">
                <label for="fb" class="form-label">Facebook <small>(opcional)</small></label>
                <input type="text" class="form-control" id="fb" name="fb" value="{{ old('fb', isset($usuario->redes_sociales['fb']) ? $usuario->redes_sociales['fb'] : '') }}">
                @error('fb')
                  <small class="fw-bold text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="mb-3 col-sm-6 col-md-3">
                <label for="tw" class="form-label">Twitter/X <small>(opcional)</small></label>
                <input type="text" class="form-control" id="tw" name="tw" value="{{ old('tw', isset($usuario->redes_sociales['tw']) ? $usuario->redes_sociales['tw'] : '') }}">
                @error('tw')
                  <small class="fw-bold text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="mb-3 col-sm-6 col-md-3">
                <label for="ig" class="form-label">Instagram <small>(opcional)</small></label>
                <input type="text" class="form-control" id="ig" name="ig" value="{{ old('ig', isset($usuario->redes_sociales['ig']) ? $usuario->redes_sociales['ig'] : '') }}">
                @error('ig')
                  <small class="fw-bold text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="mb-3 col-sm-6 col-md-3">
                <label for="tk" class="form-label">Tiktok <small>(opcional)</small></label>
                <input type="text" class="form-control" id="tk" name="tk" value="{{ old('tk', isset($usuario->redes_sociales['tk']) ? $usuario->redes_sociales['tk'] : '') }}">
                @error('tk')
                  <small class="fw-bold text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3 col-md-12" id="contenedorInputsImg">
            {{-- <input type="text" class="d-none" id="img" name="img[]"> --}}

            <label for="imagen" class="form-label">Foto de perfil <small>(opcional)</small></label>
            <input class="form-control" type="file" id="imagen" name="imagen">
            @error('imagen')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="col-md-6 editor p-0 mb-3">

          </div>

          <div class="col-md-12">
            <button type="submit" class="btn btn-primary"><i class="fas fa-solid fa-pen"></i> Editar</button>
          </div>
        </div>

      </div>
    </div>

  </form>

  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="toastPregunta" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
      <div class="toast-body">
        ¿Deseas recortar la imagen de esta forma?
        <div class="mt-2 pt-2 border-top">
          <button type="button" id="btnRecortar" class="btn btn-primary btn-sm">Recortar</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
@stop

@section('css')
  @viteReactRefresh
  @vite([
    "resources/js/admin/usuarios.js",
    "resources/css/admin/admin.css",

    'resources/js/librerias/bootstrap.js',
    'resources/css/librerias/bootstrap.css'
  ])

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" integrity="sha512-hvNR0F/e2J7zPPfLC9auFe3/SE0yG4aJCOd/qxew74NN7eyiSKjr7xJJMu1Jy2wf7FXITpWS1E/RY8yzuXN7VA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@stop

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js" integrity="sha512-9KkIqdfN7ipEW6B6k+Aq20PV31bjODg4AA52W+tYtAE0jE0kMx49bjJ3FgvS56wzmyfMUHbQ4Km2b7l9+Y/+Eg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop