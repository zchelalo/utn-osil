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

    @foreach($talleres as $key => $value)
      <article class="card text-center mb-4">
        <div class="card-header bgColor">
          <span>{{ $value->nombre }}</span>
        </div>

        <div class="bodyCardTalleres card-body d-flex justify-content-center align-items-center p-2">

          <div class="contenedorInfoTalleres col-lg-8 p-3">
            <p class="card-text">{{ $value->descripcion }}</p>
            <a href="{{ route('talleres.show', $value->id) }}" class="btn bgColor btnTalleres">Ir al taller</a>

            @if(isset($value->congresos->id))
            <a href="{{ route('congresos.show', $value->congresos->id) }}" class="btn bgColor btnTalleres">Ir al congreso</a>
            @endif

          </div>

          <div class="contenedorImgTalleres col-lg-4 p-2">
            <img class="imgTalleres img-fluid" src="{{ isset($value->img[0]) ? $value->img[0] : asset('storage/img/img-por-defecto-congresos.jpg') }}" alt="">
          </div>

        </div>

        <div class="card-footer text-body-secondary bgColor">
          2 days ago
        </div>
      </article>
    @endforeach

  </section>
@endif

@endsection