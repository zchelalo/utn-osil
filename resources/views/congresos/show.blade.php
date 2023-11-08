@extends('layouts.app')
@section('title', "Congresos UTN Osil")

@section('recursos')
@vite([
  "resources/css/congresos.css",
  "resources/js/congresos.js",

  "resources/css/librerias/swiper.css",
  "resources/js/librerias/swiper.js",
])
@endsection

@section('body')

@if(isset($congreso->id))

<div class="container-fluid">
  <section class="row col-md-12 mt-3 mb-3 d-flex justify-content-center align-items-center">
    <article class="col-md-12 mb-3">
      <h1>{{ $congreso->nombre }}</h1>
      <p>
        {{ $congreso->descripcion }}
      </p>
      @if(isset($congreso->fecha_inicio))
        <span>Duración: {{ $congreso->fecha_inicio }} - {{ $congreso->fecha_fin }}</span><br>
      @endif
      <span>Horario: <a href="#">Descargar</a></span>
    </article>
    <div class="col-md-8">@include('partials.slider-congresos')</div>
  </section>


  @if(isset($datosPorTipo) && count($datosPorTipo) > 0)

    @php
      $contador = 0;
    @endphp
    @foreach($tiposPresentacion as $tipoPresentacion)
      @if(isset($datosPorTipo[$tipoPresentacion->nombre]))
        @php
          $contador++;
        @endphp
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $contador }}" aria-expanded="false" aria-controls="flush-collapse{{ $contador }}">
                {{ $tipoPresentacion->nombre }}
              </button>
            </h2>
            <div id="flush-collapse{{ $contador }}" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              @foreach($datosPorTipo[$tipoPresentacion->nombre] as $info)
                <article class="accordion-body row">
                  <img class="imgPresentacionesCongresos img-fluid col-md-4" src="{{ $info->img != null ? $info->img : asset('storage/img/img-por-defecto-congresos.jpg') }}" alt="{{ $info->nombre }}">
                  <div class="col-md-8">
                    <h3>{{ $info->nombre }}</h3>
                    <p>
                      {{ $info->descripcion }}
                    </p>
                    <span class="spanPresentador">Por: {{ $info->usuarios->nombre }}</span><a class="btn bgColor" href="{{ route('presentaciones.show', $info->id) }}">Ver mas</a>
                  </div>
                </article>
              @endforeach
          </div>
        </div>
      @endif

    @endforeach

  @endif

  <section class="sectionFechas col-md-12">
    
  </section>

</div>

@endif

@endsection