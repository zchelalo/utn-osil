<!-- Modal -->
<div class="modal fade" id="usuariosModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <form class="modal-content" action="{{ route('admin.usuarios.store') }}" method="post">
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
            <label for="matricula" class="form-label">Matrícula</label>
            <input type="text" class="form-control" id="matricula" name="matricula" value="{{ old('matricula', '') }}">
            @error('matricula')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo', '') }}">
            @error('correo')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="{{ '' }}">
            @error('password')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-12">
            <label for="tipo_usuario" class="form-label">Tipo de usuario</label>
            <select class="form-select" aria-label="Default select example" id="tipo_usuario" name="tipo_usuario">
              @foreach($tipos_usuario as $tipo_usuario)
                <option value="{{ $tipo_usuario->id }}" {{ old('tipo_usuario') == $tipo_usuario->id ? 'selected' : '' }}>
                  {{ $tipo_usuario->nombre }}
                </option>
              @endforeach
            </select>
            @error('tipo_usuario')
              <small class="fw-bold text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 col-md-12">
            <div class="row">
              <div class="mb-3 col-sm-6 col-md-3">
                <label for="fb" class="form-label">Facebook <small>(opcional)</small></label>
                <input type="text" class="form-control" id="fb" name="fb" value="{{ old('fb', '') }}">
                @error('fb')
                  <small class="fw-bold text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="mb-3 col-sm-6 col-md-3">
                <label for="tw" class="form-label">Twitter/X <small>(opcional)</small></label>
                <input type="text" class="form-control" id="tw" name="tw" value="{{ old('tw', '') }}">
                @error('tw')
                  <small class="fw-bold text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="mb-3 col-sm-6 col-md-3">
                <label for="ig" class="form-label">Instagram <small>(opcional)</small></label>
                <input type="text" class="form-control" id="ig" name="ig" value="{{ old('ig', '') }}">
                @error('ig')
                  <small class="fw-bold text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="mb-3 col-sm-6 col-md-3">
                <label for="tk" class="form-label">Tiktok <small>(opcional)</small></label>
                <input type="text" class="form-control" id="tk" name="tk" value="{{ old('tk', '') }}">
                @error('tk')
                  <small class="fw-bold text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3 col-md-12" id="contenedorInputsImg">
            {{-- <input type="text" class="d-none" id="img" name="img[]"> --}}

            <label for="imagen" class="form-label">Foto de perfil <small>(opcional)</small></label>
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