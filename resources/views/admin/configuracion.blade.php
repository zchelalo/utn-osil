@extends($usuario->tipo_usuario->nombre != 'Administrador' ? 'layouts.app' : 'adminlte::page')

@if(session('status'))
  <script>
      window.addEventListener('load', function () {
        Swal.fire({
          text: "{{ session('status') }}",
          icon: "{{ session('icon') }}",
          confirmButtonText: 'Cerrar',
          confirmButtonColor: '#218c74'
        });
      }, false);
  </script>
@endif

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

@if($usuario->tipo_usuario->nombre != 'Administrador')
{{-- NO ADMINISTRADOR --}}

  @section('title', "Perfil")

  @section('recursos')
    @vite([
      // "resources/js/presentaciones.js"
    ])
  @endsection

  @section('body')

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <h2>
            Perfil
          </h2>
          <form class="formEdit" action="{{ route('configuracion.update', $usuario) }}" method="post">
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
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @error('password')
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
        </div>
        @if(isset($presentaciones[0]))
          <div class="col-sm-12 mt-4">
            <h2>
              Modificar presentación
            </h2>
            <div class="row p-2">

              @foreach($presentaciones as $presentacion)
                <div class="col-sm-6 col-md-4 p-1">
                  <div class="card d-flex flex-column h-100">
                    <img src="{{ isset($presentacion->img) ? asset($presentacion->img) : asset('storage/img/img-por-defecto-congresos.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body d-flex flex-column flex-grow-1">
                      <h5 class="card-title">{{ $presentacion->nombre }}</h5>
                      <p class="card-text">{{ $presentacion->descripcion }}</p>
                      <div class="mt-auto">
                        <a href="{{ route('presentaciones.edit', $presentacion) }}" class="btn btn-primary">Modificar</a>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach

            </div>
          </div>
        @endif
      </div>
    </div>

  @endsection

@else
{{-- ADMINISTRADOR --}}

  @section('title', 'Dashboard UTN Osil')

  @section('content_header')
    <h1>Perfil</h1>
  @stop

  @section('content')
    <form class="formEdit" action="{{ route('configuracion.update', $usuario) }}" method="post">
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
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password">
              @error('password')
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
  @stop

  @section('css')
    @viteReactRefresh
    @vite([
      "resources/js/admin/usuarios.js",

      'resources/js/librerias/bootstrap.js',
      'resources/css/librerias/bootstrap.css'
    ])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" integrity="sha512-hvNR0F/e2J7zPPfLC9auFe3/SE0yG4aJCOd/qxew74NN7eyiSKjr7xJJMu1Jy2wf7FXITpWS1E/RY8yzuXN7VA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  @stop

  @section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js" integrity="sha512-9KkIqdfN7ipEW6B6k+Aq20PV31bjODg4AA52W+tYtAE0jE0kMx49bjJ3FgvS56wzmyfMUHbQ4Km2b7l9+Y/+Eg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  @stop

@endif