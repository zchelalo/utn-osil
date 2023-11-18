<!-- Modal -->
<div class="modal fade" id="fechasModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <form class="modal-content" action="{{ route('admin.fechas.store') }}" method="post">
      @csrf

      <div class="modal-header bgColor">
        <h1 class="modal-title fs-5">Agregar fecha</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        
        <div class="row p-0 m-0">
          <div class="mb-3 col-md-6">
            <label for="dia" class="form-label">Día</label>
            <input type="date" class="form-control" id="dia" name="dia" value="{{ old('dia', '') }}">
            @error('dia')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="inicio" class="form-label">Inicio</label>
            <input type="time" class="form-control" id="inicio" name="inicio" value="{{ old('inicio', '') }}">
            @error('inicio')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="fin" class="form-label">Fin</label>
            <input type="time" class="form-control" id="fin" name="fin" value="{{ old('fin', '') }}">
            @error('fin')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="presentacion" class="form-label">Presentación</label>
            <select class="form-select" aria-label="Default select example" id="presentacion" name="presentacion">
              @foreach($presentaciones as $presentacion)
                <option value="{{ $presentacion->id }}" {{ old('presentacion') == $presentacion->id ? 'selected' : '' }}>
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
                <option value="{{ $congreso->id }}" {{ old('congreso') == $congreso->id ? 'selected' : '' }}>
                  {{ $congreso->nombre }}
                </option>
              @endforeach
            </select>
            @error('congreso')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

        </div>

      </div>

      <div class="modal-footer bgColor">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>

    </form>
  </div>
</div>