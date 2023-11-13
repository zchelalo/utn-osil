<!-- Modal -->
<div class="modal fade" id="congresosModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
    <form class="modal-content" action="{{ route('admin.congresos.store') }}" method="post">
      @csrf

      <div class="modal-header bgColor">
        <h1 class="modal-title fs-5">Agregar Congreso</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        
        <div class="row p-0 m-0">
          
          <div class="col-md-6">
            <div class="row">

              <div class="mb-3 col-md-12">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', '') }}">
                @error('nombre')
                  <small class="fw-bold text-danger">{{ $message }}</small>
                @enderror
              </div>
    
              <div class="mb-3 col-md-12">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion', '') }}">
                @error('descripcion')
                  <small class="fw-bold text-danger">{{ $message }}</small>
                @enderror
              </div>
    
              <div class="mb-3 col-md-12">
                <label for="organizacion" class="form-label">Organización</label>
                <select class="form-select" aria-label="Default select example" id="organizacion" name="organizacion">
                  @foreach($organizaciones as $organizacion)
                    <option value="{{ $organizacion->id }}" {{ old('organizacion') == $organizacion->id ? 'selected' : '' }}>
                      {{ $organizacion->nombre }}
                    </option>
                  @endforeach
                </select>
                @error('organizacion')
                  <small class="fw-bold text-danger">{{ $message }}</small>
                @enderror
              </div>
    
              <div class="mb-3 col-md-12">
                <label for="" class="form-label">Estado del congreso</label>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" id="activo" name="activo">
                  <label class="form-label" for="activo">
                    Activo
                  </label>
                  @error('activo')
                    <small class="fw-bold text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
    
              <div class="mb-3 col-md-12">
                <input type="text" class="d-none" id="img" name="img[]">
    
                <label for="imagen" class="form-label">Imagenes</label>
                <input class="form-control" type="file" id="imagen" name="imagen">
                @error('imagen')
                  <small class="fw-bold text-danger">{{ $message }}</small>
                @enderror
              </div>

            </div>
          </div>

          <div class="col-md-6 editor p-0">

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