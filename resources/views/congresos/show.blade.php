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
      <h1>{{ $congreso->nombre }}</h1>
      <p>
        {{ $congreso->descripcion }}
      </p>
    </article>
    <div class="col-md-8">@include('partials.slider-congresos')</div>
  </section>

  @if(isset($fechasEvento[0]))
  <section class="sectionFechas col-md-12 row">

    @if(isset($fechasTalleres[0]))
    <section class="col-md-6 mt-3">
      <div class="p-2">
        <h3>Talleres</h3>
  
        @foreach($fechasEvento as $keyEvento => $valueEvento)
          <h4>{{ ucfirst($valueEvento[1]) . ' | ' . $valueEvento[2] }}</h4>
  
          @php
            $descanso = false;
            $diaDeTaller = 0;
            $ultimaFecha = 0;
          @endphp

          @foreach($fechasTalleres as $keyTaller => $valueTaller) 
            @php
              $ultimaFecha++;
            @endphp
            @if($valueTaller->dia === $valueEvento[0])
              @php
                $diaDeTaller++;
              @endphp
            <div class="p-2">
              <article class="w-100 articulos p-2 bgColor">
                <h5>{{ $valueTaller->talleres->nombre }}</h5>
                <p>{{ $valueTaller->talleres->descripcion }}</p>
                <span>Dado por: {{ $valueTaller->talleres->usuarios->nombre }}</span><br>
                <span>Hora: {{ $valueTaller->inicio }} - {{ $valueTaller->fin }}</span>
              </article>
            </div>
            @else
              @php
                if ($diaDeTaller === 0 && $ultimaFecha === count($fechasTalleres))
                {
                  echo '
                  <div class="p-2">
                    <article class="w-100 articulos p-2 bgColor">
                      <h5>Día de descanso</h5>
                    </article>
                  </div>
                  ';
                }
              @endphp
            @endif
          @endforeach
  
        @endforeach
      </div>
    </section>
    @endif

    @if(isset($fechasConferencias[0]))
    <section class="col-md-6 mt-3">

      <div class="p-2">
        <h3>Conferencias</h3>
  
        @foreach($fechasEvento as $keyEvento => $valueEvento)
          <h4>{{ ucfirst($valueEvento[1]) . ' | ' . $valueEvento[2] }}</h4>
  
          @php
            $descanso = false;
            $diaDeConferencia = 0;
            $ultimaFecha = 0;
          @endphp

          @foreach($fechasConferencias as $keyConferencia => $valueConferencia)
            @php
              $ultimaFecha++;
            @endphp
            @if($valueConferencia->dia === $valueEvento[0])
              @php
                $diaDeConferencia++;
              @endphp
            <div class="p-2">
              <article class="w-100 articulos p-2 bgColor">
                <h5>{{ $valueConferencia->conferencias->nombre }}</h5>
                <p>{{ $valueConferencia->conferencias->descripcion }}</p>
                <span>Dado por: {{ $valueTaller->talleres->usuarios->nombre }}</span><br>
                <span>Hora: {{ $valueTaller->inicio }} - {{ $valueTaller->fin }}</span>
              </article>
            </div>
            @else
              @php
                if ($diaDeConferencia === 0 && $ultimaFecha === count($fechasConferencias))
                {
                  echo '
                  <div class="p-2">
                    <article class="w-100 articulos p-2 bgColor">
                      <h5>Día de descanso</h5>
                    </article>
                  </div>
                  ';
                }
              @endphp
            @endif
          @endforeach
  
        @endforeach
      </div>

    </section>
    @endif

  </section>
  @endif

</div>

@endif

@endsection