@extends('adminlte::page')

@section('title', 'Dashboard UTN Osil')

@section('content_header')
  <h1>Presentaciones</h1>
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
        const createModal = new bootstrap.Modal(document.getElementById('presentacionesModal'))

        // Abre el modal
        createModal.show()
      })
    </script>
  @endif

  <button type="button" class="btn bgColor btnAgregar m-0 mb-3" data-bs-toggle="modal" data-bs-target="#presentacionesModal">
    <i class="fas fa-solid fa-plus"></i> Agregar
  </button>

  <table class="table table-striped w-100" id="tablaPresentaciones">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Descripción</th>
        <th scope="col">Imagen</th>
        <th scope="col">Presentación</th>
        <th scope="col">Número de vistas</th>
        <th scope="col">Tipo de presentación</th>
        <th scope="col">Congreso</th>
        <th scope="col">Usuario</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @if(isset($presentaciones[0]))
        @foreach($presentaciones as $presentacion)
          <tr>
            <th>
              {{ $presentacion->id }}
            </th>
            <td>
              {{ $presentacion->nombre }}
            </td>
            <td>
              {{ $presentacion->descripcion }}
            </td>
            <td>
              @if(isset($presentacion->img))
                <img style="width: 100%; cursor: pointer;" class="btnVer" src="{{ $presentacion->img }}">
                <div class="d-none">
                  <ul class="images">
                    <li style="list-style: none"><img src="{{ asset($presentacion->img) }}" alt=""></li>
                  </ul>
                </div>
              @else
                Sin imagenes
              @endif
            </td>
            <td>
              {!! isset($presentacion->presentacion) ? (isset($presentacion->presentacion['pdf']) ? '<a href="'.$presentacion->presentacion['pdf'].'" target="_blank">Ver presentación</a>' : 'Otra presentacion') : 'Sin presentación' !!}
            </td>
            <td>
              {{ $presentacion->numero_vistas }}
            </td>
            <td>
              {{ $presentacion->tipo_presentacion->nombre }}
            </td>
            <td>
              {{ $presentacion->congresos->nombre }}
            </td>
            <td>
              {{ $presentacion->usuarios->nombre }}
            </td>
            <td>
              <div class="d-flex">
                <a href="{{ route('admin.presentaciones.edit', $presentacion) }}" class="btn btn-primary btn-sm mr-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                  <i class="fas fa-solid fa-pen"></i>
                </a>
                <form action="{{ route('admin.presentaciones.destroy', $presentacion) }}" method="post" class="p-0 m-0">
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

  @include('partials.modals.presentaciones')

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

  {{-- <input type="hidden" id="urlHost" name="urlHost" value="{{ url('/')}}"> --}}
@stop

@section('css')
  @viteReactRefresh
  @vite([
    "resources/js/admin/presentaciones.js",
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js" integrity="sha512-9KkIqdfN7ipEW6B6k+Aq20PV31bjODg4AA52W+tYtAE0jE0kMx49bjJ3FgvS56wzmyfMUHbQ4Km2b7l9+Y/+Eg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop