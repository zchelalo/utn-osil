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
@stop

{{-- @section('js')
  
@stop --}}