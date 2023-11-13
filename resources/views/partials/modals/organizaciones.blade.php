<!-- Modal -->
<div class="modal fade" id="organizacionesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <form class="modal-content" action="{{ route('admin.organizaciones.store') }}" method="post">
      @csrf

      <div class="modal-header bgColor">
        <h1 class="modal-title fs-5">Agregar organización</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        
        <div class="row p-0 m-0">
          <div class="mb-3 col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', '') }}">
            @error('nombre')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="pais" class="form-label">País</label>
            <input type="text" class="form-control" id="pais" name="pais" value="{{ old('pais', '') }}">
            @error('pais')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>
  
          <div class="mb-3 col-md-6">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" value="{{ old('estado', '') }}">
            @error('estado')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>
  
          <div class="mb-3 col-md-6">
            <label for="municipio" class="form-label">Municipio</label>
            <input type="text" class="form-control" id="municipio" name="municipio" value="{{ old('municipio', '') }}">
            @error('municipio')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>
  
          <div class="mb-3 col-md-6">
            <label for="colonia" class="form-label">Colonia</label>
            <input type="text" class="form-control" id="colonia" name="colonia" value="{{ old('colonia', '') }}">
            @error('colonia')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>
  
          <div class="mb-3 col-md-6">
            <label for="calle" class="form-label">Calle</label>
            <input type="text" class="form-control" id="calle" name="calle" value="{{ old('calle', '') }}">
            @error('calle')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>
  
          <div class="mb-3 col-md-6">
            <label for="numExt" class="form-label">Número exterior</label>
            <input type="text" class="form-control" id="numExt" name="numExt" value="{{ old('numExt', '') }}">
            @error('numExt')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>
  
          <div class="mb-3 col-md-6">
            <label for="numInt" class="form-label">Número interior</label>
            <input type="text" class="form-control" id="numInt" name="numInt" value="{{ old('numInt', '') }}">
            @error('numInt')
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