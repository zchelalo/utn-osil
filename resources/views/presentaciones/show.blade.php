@extends('layouts.app')
@section('title', 'Presentaciones UTN Osil')

@section('recursos')
@vite([
  "resources/css/presentaciones.css",
  "resources/js/presentaciones.js"
])

{{-- <script src="https://unpkg.com/gsap@3.9.0/dist/gsap.min.js"></script> --}}
@endsection

@section('body')

<div class="container-fluid">
@if(isset($presentaciones[0]))
  <section class="col-md-12 mt-3 text-center">

    <h2 class="">Presentaciones</h2>
    <div class="">
      @foreach($presentaciones as $presentacion)
        <p>{!! $presentacion->activo === true ? '<small class="text-success">Pendiente</small>' : '<small class="text-danger">Terminada</small>' !!} {{ $presentacion->dia }} | <small>{{ $presentacion->inicio }}</small> - <small>{{ $presentacion->fin }}</small></p>
      @endforeach
    </div>

  </section>
@endif

@endsection