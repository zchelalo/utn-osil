@extends('adminlte::page')

@section('title', 'Dashboard UTN Osil')

@section('content_header')
  <h1>Dashboard</h1>
@stop

@section('content')
  <p>Panel de administración de UTN Osil.</p>
@stop

@section('css')
  @viteReactRefresh
  @vite([
    "resources/css/admin/admin.css",

    'resources/js/librerias/bootstrap.js',
    'resources/css/librerias/bootstrap.css'
  ])
@stop