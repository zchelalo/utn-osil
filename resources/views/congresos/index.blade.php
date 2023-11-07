@extends('layouts.app')
@section('title', "Congresos UTN Osil")

@section('recursos')
@vite([
  "resources/css/congresos.css"
  // "resources/js/form.js"
])
@endsection

@section('body')

<div class="container-fluid row">
@if(isset($congresos[0]))
  <section class="col-md-8 mt-3">
    <h2 class="mb-3">Congresos</h2>
    @foreach($congresos as $key => $value)
    <a href="{{ route('congresos.show', $value->id) }}" class="card mb-3 w-100 contenedorCard">
      <div class="row g-0 contenedorInfoCard">
        <div class="col-md-3 contenedorImgCongresos d-flex justify-content-center align-items-center">
          <img src="{{ isset($value->img[0]) != null ? $value->img[0] : asset('storage/img/img-por-defecto-congresos.jpg') }}" class="imgCongresos img-fluid rounded-start" alt="...">
        </div>
        <div class="col-md-9 contenedorInfoCongresos bgColor">
          <div class="card-body">
            <h5 class="card-title">{{ $value->nombre }}</h5>
            <p class="card-text">{{ $value->descripcion }}</p>
            {{-- <p class="card-text"><small class="">Last updated 3 mins ago</small></p> --}}
          </div>
        </div>
      </div>
    </a>
    @endforeach
  </section>
@endif

@if(isset($presentaciones[0]))
  <section class="col-md-4 mt-3">
    <h2 class="mb-3">Presentaciones populares</h2>

    @foreach($presentaciones as $presentacion)
    <div class="mb-2 card"">
      <div class="card-body">
        <h5 class="card-title">{{ $presentacion->presentaciones->nombre }}</h5>
        <p class="card-text">{{ $presentacion->presentaciones->descripcion }}</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
    @endforeach
    
  </section>
@endif

</div>

@endsection