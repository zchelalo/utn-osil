@extends('adminlte::page')

@section('title', 'Dashboard UTN Osil')

@section('content_header')
  <h1>Organizaciones</h1>
@stop

@section('content')
  <table class="table table-striped w-100" id="tablaOrganizaciones">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Dirección</th>
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
              <div class="d-flex">
                <a href="" class="btn bgColor btn-sm mr-1">
                  <i class="fas fa-solid fa-pen"></i>
                </a>
                <form action="" method="post" class="p-0 m-0">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-danger btn-sm">
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

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
@stop