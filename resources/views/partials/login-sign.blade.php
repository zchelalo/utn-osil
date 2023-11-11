<!-- Login modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
    <div class="modal-content">
      <form action="{{ route('auth.store') }}" method="post">
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
</div>

<!-- Register modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
    <div class="modal-content">
      <form action="{{ route('auth.store-user') }}" method="post">
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

        </div>
        <div class="modal-footer bgColor">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Registrarse</button>
        </div>
      </form>
    </div>
  </div>
</div>