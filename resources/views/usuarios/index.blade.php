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
  <section class="row mt-2">
    <picture class="col-sm-4 col-md-3 col-lg-2">
      <img class="w-100 imgPerfil" src="{{ isset($usuario->foto_perfil) ? asset($usuario->foto_perfil) : asset('storage/img/perfil.png') }}" alt="{{ $usuario->nombre }}">
      @if(isset($usuario->redes_sociales))
        <div class="mt-3 text-center">
          @if(isset($usuario->redes_sociales['fb']))
            <a target="_blank" class="p-1" style="color: #222f3e" href="{{ $usuario->redes_sociales['fb'] }}">
              <i class="fs-5 fa-brands fa-facebook"></i>
            </a>
          @endif
          @if(isset($usuario->redes_sociales['tw']))
            <a target="_blank"class="p-1" style="color: #222f3e" href="{{ $usuario->redes_sociales['tw'] }}">
              <i class="fs-5 fa-brands fa-twitter"></i>
            </a>
          @endif
          @if(isset($usuario->redes_sociales['ig']))
            <a target="_blank" class="p-1" style="color: #222f3e" href="{{ $usuario->redes_sociales['ig'] }}">
              <i class="fs-5 fa-brands fa-instagram"></i>
            </a>
          @endif
          @if(isset($usuario->redes_sociales['tk']))
            <a target="_blank" class="p-1" style="color: #222f3e" href="{{ $usuario->redes_sociales['tk'] }}">
              <i class="fs-5 fa-brands fa-tiktok"></i>
            </a>
          @endif
        </div>
      @endif
    </picture>
    <div class="col-sm-8 col-md-9 col-lg-10">
      <h1>
        {{ $usuario->nombre }}
      </h1>
      <span>
        <b>Correo electrónico:</b> {{ $usuario->correo }}
      </span>
      <br>
      <span>
        <b>Tipo de usuario:</b> {{ $usuario->tipo_usuario->nombre }}
      </span>
    </div>
    @if(isset($presentaciones[0]))
      <div class="col-sm-12 mt-3">
        <hr>
        <div class="text-center w-100">
          <h2>Presentaciones</h2>
        </div>
        <div class="row">
          @foreach($presentaciones as $presentacion)
            <div class="col-sm-6 col-md-4 p-1">
              <div class="card d-flex flex-column h-100">
                <img src="{{ isset($presentacion->img) ? asset($presentacion->img) : asset('storage/img/img-por-defecto-congresos.jpg') }}" class="card-img-top" alt="...">
                <div class="card-body d-flex flex-column flex-grow-1">
                  <h5 class="card-title">{{ $presentacion->nombre }}</h5>
                  <p class="card-text">{{ $presentacion->descripcion }}</p>
                  <div class="mt-auto">
                    <a href="{{ route('presentaciones.show', $presentacion) }}" class="btn btn-primary">Ver presentación</a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </section>
</div>

@endsection