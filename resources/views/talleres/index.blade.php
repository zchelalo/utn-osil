@extends('layouts.app')
@section('title', "Talleres UTN Osil")

@section('recursos')
@vite([
  "resources/css/talleres.css"
])
@endsection

@section('body')

<div class="container-fluid">
@if(isset($talleres[0]))
  <section class="col-md-12 mt-3 text-center">
    <h2 class="mb-3">Talleres</h2>
    <article class="card text-center">
      <div class="card-header bgColor">
        <span>{{ $talleres[0]->nombre }}</span>
      </div>

      <div class="card-body d-flex justify-content-center align-items-center p-2">

        <div class="contenedorInfoTalleres col-xs-12 col-lg-8 row d-flex justify-content-center align-items-center p-3">
          {{-- <h5 class="card-title">{{ $talleres[0]->nombre }}</h5> --}}
          <p class="card-text col-md-12">{{ $talleres[0]->descripcion }}</p>
          <a href="#" class="btn bgColor btnTalleres m-1">Ir al taller</a>
          <a href="#" class="btn bgColor btnTalleres m-1">Ir al congreso</a>
        </div>

        <div class="contenedorImgTalleres col-xs-12 col-lg-4 p-2">
          <img class="imgTalleres img-fluid" src="{{ isset($talleres[0]->img[0]) ? $talleres[0]->img[0] : asset('storage/img/img-por-defecto-congresos.jpg') }}" alt="">
        </div>

      </div>

      <div class="card-footer text-body-secondary bgColor">
        2 days ago
      </div>
    </article>
  </section>
@endif

@endsection