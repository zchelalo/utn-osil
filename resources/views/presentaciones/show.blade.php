@extends('layouts.app')
@section('title', 'Presentaciones UTN Osil')

@section('recursos')
@vite([
  "resources/css/presentaciones.css",
  "resources/js/presentaciones.js"
])

{{-- <script src="https://unpkg.com/gsap@3.9.0/dist/gsap.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>

@endsection

@section('body')

<div class="container-fluid">
@if(isset($presentaciones[0]))
  <section class="col-md-12 mt-3 text-center row">

    <div class="col-md-8">
      <h2 class="mb-3">{{ $presentaciones[0]->presentaciones->nombre }}</h2>
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-6">
          <p>
            {{ $presentaciones[0]->presentaciones->descripcion }}
          </p>
          <p>
            Presentación dirigida por: <a href="#">{{ $presentaciones[0]->presentaciones->usuarios->nombre }}</a>
          </p>
        </div>
        <div class="col-md-6 p-3">
          <img class="w-100 imgFechaPresentacion m-0 p-0" src="{{ isset($presentaciones[0]->presentaciones->img) ? $presentaciones[0]->presentaciones->img : asset('storage/img/img-por-defecto-congresos.jpg') }}" alt="{{ $presentaciones[0]->presentaciones->nombre }}">
        </div>
      </div>
      @if(isset($presentaciones[0]->presentaciones->presentacion))
        <hr>
        <div class="col-md-12">
          <h3>
            Presentación
          </h3>
          @if(isset($presentaciones[0]->presentaciones->presentacion['pdf']))
            <div id="pdf-container" class="w-100"></div>

            <button id="btnPrev" type="button" class="btn bgColor">
              <i class="fa-solid fa-left-long"></i>
            </button>
            <span id="paginaActual" class="fw-bold p-2">1</span>
            <button id="btnNext" type="button" class="btn bgColor">
              <i class="fa-solid fa-right-long"></i>
            </button>

            <input type="hidden" id="pdfUrl" value="{{ $presentaciones[0]->presentaciones->presentacion['pdf'] }}">
          @else
            <div id="presentacion-container" class="w-100">
              
            </div>
          @endif
        </div>
        <hr class="hrPresentacion d-none">
      @endif

    </div>
    <aside class="col-md-4">
      <h2>Fechas</h2>
      @foreach($presentaciones as $presentacion)
        <div class="card mb-3 cardFechasPresentaciones">

          @if($presentacion->activo === true)
            <div class="card-header headerFechasPresentacionesPendiente">
              Pendiente
            </div>

            <div class="card-body">
              <h5 class="card-title">Día: {{ $presentacion->dia }}</h5>
              <p class="card-text">Comienza: {{ $presentacion->inicio }} Acaba: {{ $presentacion->fin }}</p>
            </div>
          @else
            <div class="card-header headerFechasPresentacionesTerminada">
              Terminada
            </div>

            <div class="card-body">
              <h5 class="card-title">Día: {{ $presentacion->dia }}</h5>
              <p class="card-text">Comenzó: {{ $presentacion->inicio }} Acabó: {{ $presentacion->fin }}</p>
            </div>
          @endif
          
        </div>
      @endforeach
    </aside>

  </section>
@endif

@endsection