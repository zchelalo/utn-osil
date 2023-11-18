@extends('adminlte::page')

@section('title', 'Dashboard UTN Osil')

@section('content_header')
  <h1>Fechas</h1>
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
        const createModal = new bootstrap.Modal(document.getElementById('fechasModal'))

        // Abre el modal
        createModal.show()
      })
    </script>
  @endif

  <button type="button" class="btn bgColor btnAgregar m-0 mb-3" data-bs-toggle="modal" data-bs-target="#fechasModal">
    <i class="fas fa-solid fa-plus"></i> Agregar
  </button>

  <table class="table table-striped w-100" id="tablaFechas">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Día</th>
        <th scope="col">Inicio</th>
        <th scope="col">Fin</th>
        <th scope="col">Estado</th>
        <th scope="col">Presentación</th>
        <th scope="col">Congreso</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @if(isset($fechas[0]))
        @foreach($fechas as $fecha)
          <tr>
            <th>
              {{ $fecha->id }}
            </th>
            <td>
              {{ $fecha->dia }}
            </td>
            <td>
              {{ $fecha->inicio }}
            </td>
            <td>
              {{ $fecha->fin }}
            </td>
            <td>
              {{ $fecha->activo == true ? 'Activo' : 'Inactivo' }}
            </td>
            <td>
              {{ $fecha->presentaciones->nombre }}
            </td>
            <td>
              {{ isset($fecha->congresos->nombre) ? $fecha->congresos->nombre : 'Sin congreso' }}
            </td>
            <td>
              <div class="d-flex">
                <a href="{{ route('admin.fechas.edit', $fecha) }}" class="btn btn-primary btn-sm mr-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                  <i class="fas fa-solid fa-pen"></i>
                </a>
                <form action="{{ route('admin.fechas.destroy', $fecha) }}" method="post" class="p-0 m-0">
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

  @include('partials.modals.fechas')

@stop

@section('css')
  @viteReactRefresh
  @vite([
    "resources/js/admin/fechas.js",
    "resources/css/admin/admin.css",

    'resources/js/librerias/bootstrap.js',
    'resources/css/librerias/bootstrap.css'
  ])
@stop

{{-- @section('js')
  
@stop --}}