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

@if($usuario->tipo_usuario->nombre != 'Administrador')
{{-- NO ADMINISTRADOR --}}

  @section('title', "Perfil")

  @section('recursos')
  @vite([
    // "resources/css/presentaciones.css",
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

            {{-- <div class="mb-3 col-md-6">
              <label for="tipo_usuario" class="form-label">Tipo de usuario</label>
              <select class="form-select" aria-label="Default select example" id="tipo_usuario" name="tipo_usuario">
                @foreach($tipos_usuario as $tipo_usuario)
                  <option value="{{ $tipo_usuario->id }}" {{ $tipo_usuario->id == $usuario->id_tipo_usuario ? 'selected' : '' }}>
                    {{ $tipo_usuario->nombre }}
                  </option>
                @endforeach
              </select>
              @error('tipo_usuario')
                <small class="fw-bold text-danger">{{ $message }}</small>
              @enderror
            </div> --}}

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
      // "resources/css/admin/admin.css",

      'resources/js/librerias/bootstrap.js',
      'resources/css/librerias/bootstrap.css'
    ])
  @stop

@endif