@extends('adminlte::page')

@section('title', 'Dashboard UTN Osil')

@section('content_header')
  <h1>Presentaciones</h1>
@stop

@section('content')
  <form class="formEdit" action="{{ route('admin.presentaciones.update', $presentacion) }}" method="post" enctype="multipart/form-data">
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
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $presentacion->nombre) }}">
            @error('nombre')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="lugar" class="form-label">Lugar</label>
            <input type="text" class="form-control" id="lugar" name="lugar" value="{{ old('lugar', $presentacion->lugar) }}">
            @error('lugar')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea style="resize: none;" rows="3" class="form-control" id="descripcion" name="descripcion">{{ old('descripcion', $presentacion->descripcion) }}</textarea>
            @error('descripcion')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="presentacion" class="form-label">Presentación <small>(opcional)</small></label>
            <input class="form-control" type="file" id="presentacion" name="presentacion">
            @error('presentacion')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
            <small>Recuerde que la presentación es en formato PDF</small>

            @if(isset($presentacion->presentacion['pdf']))
              <br>
              <div class="mt-2">
                <a href="{{ $presentacion->presentacion['pdf'] }}" target="_blank" class="btn bgColor" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ver presentación"><i class="fas fa-solid fa-eye"></i></a>
                <button id="btnQuitarPresentacion" type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar presentación">
                  X
                </button>
              </div>
            @endif
          </div>

          <div class="mb-3 col-md-6">
            <label for="tipo" class="form-label">Tipo de presentación</label>
            <select class="form-select" aria-label="Default select example" id="tipo" name="tipo">
              @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}" {{ $tipo->id == $presentacion->id_tipo_presentacion ? 'selected' : '' }}>
                  {{ $tipo->nombre }}
                </option>
              @endforeach
            </select>
            @error('tipo')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="congreso" class="form-label">Congreso</label>
            <select class="form-select" aria-label="Default select example" id="congreso" name="congreso">
              <option value="0" {{ old('congreso') == null ? 'selected' : '' }}>
                Sin congreso
              </option>
              @foreach($congresos as $congreso)
                <option value="{{ $congreso->id }}" {{ $congreso->id == $presentacion->id_congreso ? 'selected' : '' }}>
                  {{ $congreso->nombre }}
                </option>
              @endforeach
            </select>
            @error('congreso')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="usuario" class="form-label">Usuarios</label>
            <select class="form-select" aria-label="Default select example" id="usuario" name="usuario">
              @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}" {{ $usuario->id == $presentacion->id_usuario ? 'selected' : '' }}>
                  {{ $usuario->nombre }}
                </option>
              @endforeach
            </select>
            @error('usuario')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-12" id="contenedorInputsImg">
            {{-- <input type="text" class="d-none" id="img" name="img[]"> --}}

            <label for="imagen" class="form-label">Imagen <small>(opcional)</small></label>
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
  <form action="{{ route('admin.presentaciones.update-presentacion', $presentacion) }}" class="d-none" method="post">
    @csrf
    @method('put')

    <button id="eliminarRuta" type="submit" class="d-none"></button>
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
    "resources/js/admin/presentaciones.js",
    "resources/css/admin/admin.css",

    'resources/js/librerias/bootstrap.js',
    'resources/css/librerias/bootstrap.css'
  ])

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" integrity="sha512-hvNR0F/e2J7zPPfLC9auFe3/SE0yG4aJCOd/qxew74NN7eyiSKjr7xJJMu1Jy2wf7FXITpWS1E/RY8yzuXN7VA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@stop

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js" integrity="sha512-9KkIqdfN7ipEW6B6k+Aq20PV31bjODg4AA52W+tYtAE0jE0kMx49bjJ3FgvS56wzmyfMUHbQ4Km2b7l9+Y/+Eg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop