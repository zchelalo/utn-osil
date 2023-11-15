@extends('adminlte::page')

@section('title', 'Dashboard UTN Osil')

@section('content_header')
  <h1>Congresos</h1>
@stop

@section('content')
  <form class="formEdit" action="{{ route('admin.congresos.update', $congreso) }}" method="post">
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
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $congreso->nombre) }}">
            @error('nombre')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion', $congreso->descripcion) }}">
            @error('descripcion')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="organizacion" class="form-label">Organización</label>
            <select class="form-select" aria-label="Default select example" id="organizacion" name="organizacion">
              @foreach($organizaciones as $organizacion)
                <option value="{{ $organizacion->id }}" {{ $organizacion->id == $congreso->id_organizacion ? 'selected' : '' }}>
                  {{ $organizacion->nombre }}
                </option>
              @endforeach
            </select>
            @error('organizacion')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="" class="form-label">Estado del congreso</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" {{ old('activo', $congreso->descripcion) ? 'checked' : '' }} id="activo" name="activo">
              <label class="form-label" for="activo">
                Activo
              </label>
              @error('activo')
                <small class="fw-bold text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

          @if(isset($congreso->img[0]))
            <div class="mb-3 mt-3 col-md-12">
              <div class="row" id="rowContenedorImgCongreso">
                @foreach($congreso->img as $img)
                <div class="contenedorImgCongreso col-sm-6 col-md-4" style="position: relative">
                  <input type="text" class="d-none imgCongresoBase64" name="img[]">
                  <img class="w-100 imgCongreso" src="{{ asset($img) }}" alt="">
                  <button type="button" class="btnImgCongreso btn btn-danger btn-sm">
                    x
                  </button>
                </div>
              @endforeach
              </div>
            </div>
          @endif

          <div class="mb-3 col-md-12" id="contenedorInputsImg">
            <label for="imagen" class="form-label">Agregar imagenes <small>(opcional)</small></label>
            <input class="form-control" type="file" id="imagen" name="imagen">
            <small>Tome en cuenta que el total de peso de las imagenes no debe superar los 20MB</small>
            @error('imagen')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6 editor p-0">

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
          <button type="button" id="btnRecortarEdit" class="btn btn-primary btn-sm">Recortar</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
@stop

@section('css')
  @viteReactRefresh
  @vite([
    "resources/js/admin/congresos.js",
    "resources/css/admin/admin.css",

    'resources/js/librerias/bootstrap.js',
    'resources/css/librerias/bootstrap.css'
  ])

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" integrity="sha512-hvNR0F/e2J7zPPfLC9auFe3/SE0yG4aJCOd/qxew74NN7eyiSKjr7xJJMu1Jy2wf7FXITpWS1E/RY8yzuXN7VA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@stop

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js" integrity="sha512-9KkIqdfN7ipEW6B6k+Aq20PV31bjODg4AA52W+tYtAE0jE0kMx49bjJ3FgvS56wzmyfMUHbQ4Km2b7l9+Y/+Eg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop