@extends('layouts.app')
@section('title', "Congresos UTN Osil")

@section('recursos')
@vite([
  "resources/css/congresos.css"
  // "resources/js/form.js"
])
@endsection

@section('body')

<div class="container-fluid row">
@if(isset($congresos[0]))
  <section class="col-md-8 mt-3">
    <h2 class="mb-3">Congresos</h2>
    @foreach($congresos as $key => $value)
    <a href="{{ route('congresos.show', $value->id) }}" class="card mb-3 w-100 contenedorCard">
      <div class="row g-0 contenedorInfoCard">
        <div class="col-md-3 contenedorImgCongresos d-flex justify-content-center align-items-center">
          <img src="{{ $value->img != null ? $value->img : asset('storage/img/img-por-defecto-congresos.jpg') }}" class="imgCongresos img-fluid rounded-start" alt="...">
        </div>
        <div class="col-md-9 contenedorInfoCongresos bgColor">
          <div class="card-body">
            <h5 class="card-title">{{ $value->nombre }}</h5>
            <p class="card-text">{{ $value->descripcion }}</p>
            {{-- <p class="card-text"><small class="">Last updated 3 mins ago</small></p> --}}
          </div>
        </div>
      </div>
    </a>
    @endforeach
  </section>
@endif
  <section class="col-md-4 mt-3">

    <h2 class="mb-3">Talleres populares</h2>

    <div class="mb-2 card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
    <div class="mb-2 card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
    <div class="mb-2 card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>

    <hr>

    <h2 class="mb-3">Conferencias populares</h2>

    <div class="mb-2 card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
    <div class="mb-2 card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
    <div class="mb-2 card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>

  </section>

</div>

@endsection