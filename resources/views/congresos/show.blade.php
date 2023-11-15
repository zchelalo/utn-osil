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
    <article class="col-md-12">
      <div class="row text-center p-2">
        <h1>{{ $congreso->nombre }}</h1>
  
        <div class="col-md-12 mb-2 p-1">
          <div class="card">
            <div class="card-body">
              {{ $congreso->descripcion }}
            </div>
          </div>
        </div>


        @if(isset($congreso->fecha_inicio) && isset($congreso->fecha_fin))
          <div class="col-md-6 mb-2 p-1">
            <div class="card">
              <div class="card-body">
                <span>Duración: {{ $congreso->fecha_inicio }} - {{ $congreso->fecha_fin }}</span><br>
              </div>
            </div>
          </div>

          <div class="col-md-6 mb-2 p-1">
            <div class="card">
              <div class="card-body">
                <span>Horario: <a href="{{ route('horario', $congreso->id) }}">Descargar</a></span>
              </div>
            </div>
          </div>
        @endif

        
  
        @if(isset($congreso->organizaciones->nombre))
          <div class="col-md-12 mb-2 p-1">
            <div class="card">
              <div class="card-body">
                Organizado por: <a href="#">{{ $congreso->organizaciones->nombre }}</a>
              </div>
            </div>
          </div>
        @endif
  
      </div>
    </article>
    <div class="col-md-12">@include('partials.slider-congresos')</div>
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