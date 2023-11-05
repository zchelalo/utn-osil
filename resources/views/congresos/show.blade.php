@extends('layouts.app')
@section('title', "Congresos UTN Osil")

@section('recursos')
@vite([
  "resources/css/congresos.css"
  // "resources/js/form.js"
])
@endsection

@section('body')

@if(isset($congreso->id))
<div class="container-fluid row">
  <section class="col-md-8 mt-3">
    {{ $congreso->nombre }}
    <br><br>
    {{ $congreso->descripcion }}
    <br><br>
    {{ $congreso->img != null ? $congreso->img : 'No tiene imagen' }}
    <br><br>
    {{ $congreso->organizaciones->nombre }}
    <br><br>
    {{ var_dump($congreso->organizaciones->direccion) }}
  </section>
  <section class="col-md-4 mt-3">

  </section>
</div>
@endif

@endsection