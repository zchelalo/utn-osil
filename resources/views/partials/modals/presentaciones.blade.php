<!-- Modal -->
<div class="modal fade" id="presentacionesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <form class="modal-content" action="{{ route('admin.presentaciones.store') }}" method="post" enctype="multipart/form-data">
      @csrf

      <div class="modal-header bgColor">
        <h1 class="modal-title fs-5">Agregar presentación</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        
        <div class="row p-0 m-0">

          <div class="mb-3 col-md-12">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', '') }}">
            @error('nombre')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-12">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea style="resize: none;" rows="3" class="form-control" id="descripcion" name="descripcion">{{ old('descripcion', '') }}</textarea>
            @error('descripcion')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="presentacion" class="form-label">Presentación <small>(opcional)</small></label>
            <input class="form-control" type="file" id="presentacion" name="presentacion">
            @error('presentacion')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
            <small>Recuerde que la presentación es en formato PDF</small>
          </div>

          <div class="mb-3 col-md-6">
            <label for="tipo" class="form-label">Tipo de presentación</label>
            <select class="form-select" aria-label="Default select example" id="tipo" name="tipo">
              @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}" {{ old('tipo') == $tipo->id ? 'selected' : '' }}>
                  {{ $tipo->nombre }}
                </option>
              @endforeach
            </select>
            @error('tipo')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="congreso" class="form-label">Congreso</label>
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

          <div class="mb-3 col-md-6">
            <label for="usuario" class="form-label">Usuarios</label>
            <select class="form-select" aria-label="Default select example" id="usuario" name="usuario">
              @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}" {{ old('usuario') == $usuario->id ? 'selected' : '' }}>
                  {{ $usuario->nombre }}
                </option>
              @endforeach
            </select>
            @error('usuario')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-12" id="contenedorInputsImg">
            {{-- <input type="text" class="d-none" id="img" name="img[]"> --}}

            <label for="imagen" class="form-label">Imagen <small>(opcional)</small></label>
            <input class="form-control" type="file" id="imagen" name="imagen">
            @error('imagen')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="col-md-12 editor p-0">

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