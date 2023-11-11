@extends('layouts.app')
@section('title', "UTN Osil")

{{-- @section('recursos')
@vite([

])
@endsection --}}

@section('body')
<section class="container-fluid">

  <div class="row">
    @if(isset($congresos[0]))
      <section class="col-md-8 text-center">
        <h2>Congresos anteriores</h2>
        <div class="row">
          
          @foreach($congresos as $congreso)
            <div class="p-2">
              <div class="card col-md-12">
                <div class="card-body">
                  <h5 class="card-title">{{ $congreso->nombre }}</h5>
                  @if(isset($congreso->dias_pasados))
                    <h6 class="card-subtitle mb-2 text-body-secondary">Hace {{ $congreso->dias_pasados }} días</h6>
                  @endif
                  <p class="card-text">{{ $congreso->descripcion }}</p>
                  <a href="{{ route('congresos.show', $congreso->id) }}" class="btn bgColor">Ir al congreso</a>
                </div>
              </div>
            </div>
          @endforeach

        </div>
      </section>
    @endif

    <section class="col-md-4 text-center">
      <h2>Profesores</h2>
      <div class="row">

        <div class="p-2 col-md-6">
          <article class="card">
            <img src="http://www.utnogales.edu.mx/img/bg-img/gallery3.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </article>
        </div>

        <div class="p-2 col-md-6">
          <article class="card">
            <img src="http://www.utnogales.edu.mx/img/bg-img/gallery2.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </article>
        </div>

        <div class="p-2 col-md-6">
          <article class="card">
            <img src="http://www.utnogales.edu.mx/img/bg-img/gallery1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </article>
        </div>

        <div class="p-2 col-md-6">
          <article class="card">
            <img src="http://www.utnogales.edu.mx/img/bg-img/gallery3.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </article>
        </div>

      </div>
    </section>
  </div>

</section>
@endsection