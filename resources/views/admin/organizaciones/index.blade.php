@extends('adminlte::page')

@section('title', 'Dashboard UTN Osil')

@section('content_header')
  <h1>Organizaciones</h1>
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
        const createModal = new bootstrap.Modal(document.getElementById('organizacionesModal'))

        // Abre el modal
        createModal.show()
      })
    </script>
  @endif

  <button type="button" class="btn bgColor btnAgregar m-0 mb-3" data-bs-toggle="modal" data-bs-target="#organizacionesModal">
    <i class="fas fa-solid fa-plus"></i> Agregar
  </button>

  <table class="table table-striped w-100" id="tablaOrganizaciones">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">País</th>
        <th scope="col">Estado</th>
        <th scope="col">Municipio</th>
        <th scope="col">Colonia</th>
        <th scope="col">Calle</th>
        <th scope="col">Núm exterior</th>
        <th scope="col">Núm interior</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @if(isset($organizaciones[0]))
        @foreach($organizaciones as $organizacion)
          <tr>
            <th>
              {{ $organizacion->id }}
            </th>
            <td>
              {{ $organizacion->nombre }}
            </td>
            <td>
              {{ $organizacion->direccion['pais'] }}
            </td>
            <td>
              {{ $organizacion->direccion['estado'] }}
            </td>
            <td>
              {{ $organizacion->direccion['municipio'] }}
            </td>
            <td>
              {{ $organizacion->direccion['colonia'] }}
            </td>
            <td>
              {{ $organizacion->direccion['calle'] }}
            </td>
            <td>
              {{ $organizacion->direccion['num_ext'] }}
            </td>
            <td>
              {{ $organizacion->direccion['num_int'] }}
            </td>
            <td>
              <div class="d-flex">
                <a href="{{ route('admin.organizaciones.edit', $organizacion) }}" class="btn btn-primary btn-sm mr-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                  <i class="fas fa-solid fa-pen"></i>
                </a>
                <form action="{{ route('admin.organizaciones.destroy', $organizacion) }}" method="post" class="p-0 m-0">
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

  @include('partials.modals.organizaciones')

  {{-- <input type="hidden" id="urlHost" name="urlHost" value="{{ url('/')}}"> --}}
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

{{-- @section('js')
  
@stop --}}