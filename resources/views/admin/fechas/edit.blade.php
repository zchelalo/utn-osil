@extends('adminlte::page')

@section('title', 'Dashboard UTN Osil')

@section('content_header')
  <h1>Fechas</h1>
@stop

@section('content')
  <form class="formEdit" action="{{ route('admin.fechas.update', $fecha) }}" method="post">
    @csrf
    @method('put')

    <div class="card">
      <div class="card-header">
        Editar información
      </div>
      <div class="card-body">

        <div class="row p-0 m-0">
          <div class="mb-3 col-md-6">
            <label for="dia" class="form-label">Día</label>
            <input type="date" class="form-control" id="dia" name="dia" value="{{ old('dia', $fecha->dia) }}">
            @error('dia')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="inicio" class="form-label">Inicio</label>
            <input type="time" class="form-control" id="inicio" name="inicio" value="{{ old('inicio', $fecha->inicio) }}">
            @error('inicio')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="fin" class="form-label">Fin</label>
            <input type="time" class="form-control" id="fin" name="fin" value="{{ old('fin', $fecha->fin) }}">
            @error('fin')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="presentacion" class="form-label">Presentación</label>
            <select class="form-select" aria-label="Default select example" id="presentacion" name="presentacion">
              @foreach($presentaciones as $presentacion)
                <option value="{{ $presentacion->id }}" {{ $fecha->id_presentacion == $presentacion->id ? 'selected' : '' }}>
                  {{ $presentacion->nombre }}
                </option>
              @endforeach
            </select>
            @error('presentacion')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="congreso" class="form-label">Congreso (opcional)</label>
            <select class="form-select" aria-label="Default select example" id="congreso" name="congreso">
              <option value="0" {{ old('congreso') == null ? 'selected' : '' }}>
                Sin congreso
              </option>
              @foreach($congresos as $congreso)
                <option value="{{ $congreso->id }}" {{ $fecha->id_congreso == $congreso->id ? 'selected' : '' }}>
                  {{ $congreso->nombre }}
                </option>
              @endforeach
            </select>
            @error('congreso')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="col-md-12">
            <button type="submit" class="btn btn-primary"><i class="fas fa-solid fa-pen"></i> Editar</button>
          </div>
        </div>

      </div>
    </div>

  </form>
@stop

@section('css')
  @viteReactRefresh
  @vite([
    "resources/js/admin/fechas.js",
    "resources/css/admin/admin.css",

    'resources/js/librerias/bootstrap.js',
    'resources/css/librerias/bootstrap.css'
  ])
@stop