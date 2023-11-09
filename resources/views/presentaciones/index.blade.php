@extends('layouts.app')
@section('title', "Presentaciones UTN Osil")

@section('recursos')
@vite([
  "resources/css/presentaciones.css",
  "resources/js/presentaciones.js"
])

<script src="https://unpkg.com/gsap@3.9.0/dist/gsap.min.js"></script>
@endsection

@section('body')

<div class="container-fluid">
@if(isset($presentaciones[1]))
  <section class="col-md-12 mt-3 text-center">
    <div class="mb-3">
      <h2 class="">Presentaciones</h2>
      <div class="col-md-12 d-flex justify-content-center align-items-center">
        {{-- <span class="p-2">
          <i class="fa-solid fa-magnifying-glass"></i>
        </span> --}}
        <input class="form-control me-2" type="search" id="buscador" placeholder="Buscar" aria-label="Buscar">
        @if(isset($tipo_presentaciones[0]))
          <div class="dropdown p-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Filtrar
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item tipoPresentaciones" id-tipo='' href="#">Quitar filtros</a></li>
              @foreach($tipo_presentaciones as $tipo)
                <li><a class="dropdown-item tipoPresentaciones" id-tipo='{{ $tipo->id }}' href="#">{{ $tipo->nombre }}</a></li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    </div>

    <div class="p-0 m-0" id="articulosDePresentaciones">
      @foreach($presentaciones as $presentacion)
        <article class="card text-center mb-4">
          <div class="card-header bgColor">
            <span>{{ $presentacion[0]->presentaciones->nombre }}</span>
          </div>
  
          <div class="bodyCardPresentaciones card-body d-flex justify-content-center align-items-center p-2">
  
            <div class="contenedorInfoPresentaciones col-lg-8 p-3">
              <p class="card-text">{{ $presentacion[0]->presentaciones->descripcion }}</p>
              @if($presentacion[0]->tipo_presentacion_nombre === 'Otro')
                <a href="{{ route('presentaciones.show', $presentacion[0]->presentaciones->id) }}" class="btn bgColor btnPresentaciones">Ir a Presentación</a>
              @else
                <a href="{{ route('presentaciones.show', $presentacion[0]->presentaciones->id) }}" class="btn bgColor btnPresentaciones">Ir a {{ $presentacion[0]->tipo_presentacion_nombre }}</a>
              @endif
  
              @if(isset($presentacion[0]->congresos->id))
                <a href="{{ route('congresos.show', $presentacion[0]->congresos->id) }}" class="btn bgColor btnPresentaciones">Ir al congreso</a>
              @endif
  
            </div>
  
            <div class="contenedorImgPresentaciones col-lg-4 p-2">
              <img class="imgPresentaciones img-fluid" src="{{ isset($presentacion[0]->presentaciones->img) ? $presentacion[0]->presentaciones->img : asset('storage/img/img-por-defecto-congresos.jpg') }}" alt="">
            </div>
  
          </div>
  
          <div class="card-footer text-body-secondary bgColor">
            De: <small>{{ $presentacion[0]->dia }}</small>
            A: <small>{{ $presentacion[count($presentacion) - 1]->dia }}</small>
          </div>
        </article>
      @endforeach
    </div>

  </section>
@endif

@endsection