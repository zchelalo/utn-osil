<!-- Login modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
    <form class="modal-content" action="{{ route('auth.store') }}" method="post">
      @csrf
      <div class="modal-header bgColor">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Iniciar sesión</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="mb-3">
          <label for="loginCorreo" class="form-label">Correo</label>
          <input type="email" id="loginCorreo" name="loginCorreo" class="form-control" placeholder="correo@example.com" value="{{ old('loginCorreo', '') }}">
          @error('loginCorreo')
            <small class="fw-bold text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="mb-3">
          <label for="loginPassword" class="form-label">Password</label>
          <input type="password" id="loginPassword" name="loginPassword" class="form-control" aria-describedby="passwordHelpBlock">
        </div>

      </div>
      <div class="modal-footer bgColor">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Iniciar sesión</button>
      </div>
    </form>
  </div>
</div>

<!-- Register modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <form class="modal-content" action="{{ route('auth.store-user') }}" method="post">
      @csrf
      <div class="modal-header bgColor">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrarse</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre', '') }}">
          @error('nombre')
            <small class="fw-bold text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-3">
          <label for="matricula" class="form-label">Matrícula <small>(opcional)</small></label>
          <input type="text" id="matricula" name="matricula" class="form-control" value="{{ old('matricula', '') }}">
          @error('matricula')
            <small class="fw-bold text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-3">
          <label for="correo" class="form-label">Correo</label>
          <input type="email" id="correo" name="correo" class="form-control" placeholder="correo@example.com" value="{{ old('correo', '') }}">
          @error('correo')
            <small class="fw-bold text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" name="password" class="form-control" aria-describedby="passwordHelpBlock">
          @error('password')
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
      <div class="modal-footer bgColor">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Registrarse</button>
      </div>
    </form>
  </div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3">
  <div id="toastPregunta" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
    <div class="toast-body">
      ¿Deseas recortar la imagen de esta forma?
      <div class="mt-2 pt-2 border-top">
        <button type="button" id="btnRecortar" class="btn btn-primary btn-sm">Recortar</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Cerrar</button>
      </div>
    </div>
  </div>
</div>