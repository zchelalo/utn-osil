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
  <section class="row">
    <picture class="col-sm-4 col-md-3 col-lg-2">
      <img class="w-100" src="{{ isset($usuario->foto_perfil) ? asset($usuario->foto_perfil) : asset('storage/img/perfil.png') }}" alt="{{ $usuario->nombre }}">
    </picture>
    <div class="col-sm-8 col-md-9 col-lg-10">
      <h1>
        {{ $usuario->nombre }}
      </h1>
      <span>
        <b>Correo:</b> {{ $usuario->correo }}
      </span>
      <br>
      <span>
        <b>Tipo de usuario:</b> {{ $usuario->tipo_usuario->nombre }}
      </span>
    </div>
  </section>
</div>

@endsection