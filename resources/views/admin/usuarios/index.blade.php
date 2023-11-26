@extends('adminlte::page')

@section('title', 'Dashboard UTN Osil')

@section('content_header')
  <h1>Usuarios</h1>
@stop

@section('content')
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
  @if($errors->any())
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Obtén una referencia al modal por su ID
        const createModal = new bootstrap.Modal(document.getElementById('usuariosModal'))

        // Abre el modal
        createModal.show()
      })
    </script>
  @endif

  <button type="button" class="btn bgColor btnAgregar m-0 mb-3" data-bs-toggle="modal" data-bs-target="#usuariosModal">
    <i class="fas fa-solid fa-plus"></i> Agregar
  </button>

  <table class="table table-striped w-100" id="tablaUsuarios">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Matrícula</th>
        <th scope="col">Correo</th>
        <th scope="col">Foto de perfil</th>
        <th scope="col">Redes sociales</th>
        <th scope="col">Tipo de usuario</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @if(isset($usuarios[0]))
        @foreach($usuarios as $usuario)
          <tr>
            <th>
              {{ $usuario->id }}
            </th>
            <td>
              {{ $usuario->nombre }}
            </td>
            <td>
              {{ isset($usuario->matricula) ? $usuario->matricula : 'No cuenta con matrícula' }}
            </td>
            <td>
              {{ $usuario->correo }}
            </td>
            <td>
              @if(isset($usuario->foto_perfil))
                <img style="cursor: pointer;" class="btnVer imgPerfilUsuarios" src="{{ $usuario->foto_perfil }}">
                <div class="d-none">
                  <ul class="images">
                    <li style="list-style: none"><img src="{{ asset($usuario->foto_perfil) }}" alt=""></li>
                  </ul>
                </div>
              @else
                Sin imagenes
              @endif
            </td>
            <td>
              @if(isset($usuario->redes_sociales))
                <div>
                  @if(isset($usuario->redes_sociales['fb']))
                    <a target="_blank" class="p-1" style="color: #222f3e" href="{{ $usuario->redes_sociales['fb'] }}">
                      <i class="fs-5 fa-brands fa-facebook"></i>
                    </a>
                  @endif
                  @if(isset($usuario->redes_sociales['tw']))
                    <a target="_blank" class="p-1" style="color: #222f3e" href="{{ $usuario->redes_sociales['tw'] }}">
                      <i class="fs-5 fa-brands fa-twitter"></i>
                    </a>
                  @endif
                  @if(isset($usuario->redes_sociales['ig']))
                    <a target="_blank" class="p-1" style="color: #222f3e" href="{{ $usuario->redes_sociales['ig'] }}">
                      <i class="fs-5 fa-brands fa-instagram"></i>
                    </a>
                  @endif
                  @if(isset($usuario->redes_sociales['tk']))
                    <a target="_blank" class="p-1" style="color: #222f3e" href="{{ $usuario->redes_sociales['tk'] }}">
                      <i class="fs-5 fa-brands fa-tiktok"></i>
                    </a>
                  @endif
                </div>
              @else
                Sin redes sociales
              @endif
            </td>
            <td>
              {{ $usuario->tipo_usuario->nombre }}
            </td>
            <td>
              <div class="d-flex">
                <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-primary btn-sm mr-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                  <i class="fas fa-solid fa-pen"></i>
                </a>
                <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="post" class="p-0 m-0">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar">
                    <i class="fas fa-solid fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>
  <br><br>

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

  @include('partials.modals.usuarios')

  {{-- <input type="hidden" id="urlHost" name="urlHost" value="{{ url('/')}}"> --}}
@stop

@section('css')
  @viteReactRefresh
  @vite([
    "resources/js/admin/usuarios.js",
    "resources/css/admin/admin.css",

    'resources/js/librerias/bootstrap.js',
    'resources/css/librerias/bootstrap.css'
  ])

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.css" integrity="sha512-za6IYQz7tR0pzniM/EAkgjV1gf1kWMlVJHBHavKIvsNoUMKWU99ZHzvL6lIobjiE2yKDAKMDSSmcMAxoiWgoWA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" integrity="sha512-hvNR0F/e2J7zPPfLC9auFe3/SE0yG4aJCOd/qxew74NN7eyiSKjr7xJJMu1Jy2wf7FXITpWS1E/RY8yzuXN7VA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@stop

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.js" integrity="sha512-EC3CQ+2OkM+ZKsM1dbFAB6OGEPKRxi6EDRnZW9ys8LghQRAq6cXPUgXCCujmDrXdodGXX9bqaaCRtwj4h4wgSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.common.min.js" integrity="sha512-Lz/6nSYe4HNv0bbr5OsVaqQCNvWjtowEO2KN82rcoTeJeapLPsxIHiWxx7O8T9+Swf3lxBMfd3rV45W0X4WCsg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.esm.min.js" integrity="sha512-9dr4e1eVAKj75w/m1ukoyDlcrI5JtM5dm2LgbP3HdOqAH+tdw1ylZjYwiX+9FxcLV+UcYIydLwFm28H5HUeiBg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://kit.fontawesome.com/be5e2a9675.js" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js" integrity="sha512-9KkIqdfN7ipEW6B6k+Aq20PV31bjODg4AA52W+tYtAE0jE0kMx49bjJ3FgvS56wzmyfMUHbQ4Km2b7l9+Y/+Eg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop