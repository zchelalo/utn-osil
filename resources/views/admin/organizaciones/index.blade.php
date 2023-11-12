@extends('adminlte::page')

@section('title', 'Dashboard UTN Osil')

@section('content_header')
  <h1>Organizaciones</h1>
@stop

@section('content')
  <table class="table table-striped" id="tablaOrganizaciones">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Dirección</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>

  <input type="hidden" id="urlHost" name="urlHost" value="{{ url('/')}}">
@stop

@section('css')
  @viteReactRefresh
  @vite([
    "resources/js/admin/organizaciones.js",
    "resources/css/admin/organizaciones.css",

    'resources/js/librerias/bootstrap.js',
    'resources/css/librerias/bootstrap.css'
  ])
@stop