<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="@yield('meta-description', 'UTN Osil, laboratorio de software libre')">
  <title>@yield('title')</title>

  @viteReactRefresh
  @vite([
    "resources/js/index.jsx",
    "resources/js/app.jsx",

    "resources/css/app.css",
    
    // 'resources/sass/app.scss',

    "resources/js/librerias/popper.js",
    
    'resources/js/librerias/bootstrap.js',
    'resources/css/librerias/bootstrap.css'
  ])

  @yield('recursos')

  <script src="https://kit.fontawesome.com/be5e2a9675.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
  @if(session('token'))

    <script>
      const token = "{{ session('token') }}"
      // Almacenar el token en una cookie
      document.cookie = `token=${token}; path=/; secure; samesite=strict; max-age=7200;`;
    </script>
  @endif
  @if(session('status'))
    <script>
        window.addEventListener('load', function () {
          Swal.fire({
            text: "{{ session('status') }}",
            icon: "{{ session('icon') }}",
            confirmButtonText: 'Cerrar',
            confirmButtonColor: '#218c74'
          });
        }, false);
    </script>
  @endif
  @if(session('login') === 'open')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Obtén una referencia al modal por su ID
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'))

        // Abre el modal
        loginModal.show()
      })
    </script>
  @endif
  @if($errors->has('nombre') || $errors->has('matricula') || $errors->has('correo') || $errors->has('password'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Obtén una referencia al modal por su ID
        const registerModal = new bootstrap.Modal(document.getElementById('registerModal'))

        // Abre el modal
        registerModal.show()
      })
    </script>
  @endif
  <div id="root"></div>
  <header>
    <nav class="navbar fixed-top bgColor">
      <div class="container-fluid">
        <i class="fa-solid fa-bars bgColor icono" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation"></i>
        <a class="navbar-brand" href="{{ route('inicio') }}">UTN Osil</a>
        <div class="offcanvas offcanvas-start bgColor" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title tituloNav" id="offcanvasNavbarLabel">UTN Osil</h5>
            <i class="fa-solid fa-xmark textColor icono" data-bs-dismiss="offcanvas" aria-label="Close"></i>
          </div>
          <div class="offcanvas-body d-flex flex-column">
            
            <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">

              <li class="nav-item itemNav row d-flex justify-content-center align-items-center mb-2">
                <i class="fa-solid fa-house iconoNav col-md-2 pl-2 m-0"></i>
                <a class="nav-link col-md-10 p-0 m-0 linkRutas {{ request()->routeIs('inicio') ? 'active' : '' }}" href="{{ route('inicio') }}">Inicio</a>
              </li>

              <li class="nav-item itemNav row d-flex justify-content-center align-items-center mb-2">
                <i class="fa-regular fa-calendar-days iconoNav col-md-2 pl-2 m-0"></i>
                <a class="nav-link col-md-10 p-0 m-0 linkRutas {{ request()->routeIs('congresos') ? 'active' : '' }}" href="{{ route('congresos') }}">Congresos</a>
              </li>

              <li class="nav-item itemNav row d-flex justify-content-center align-items-center mb-2">
                <i class="fa-solid fa-graduation-cap iconoNav col-md-2 pl-2 m-0"></i>
                <a class="nav-link col-md-10 p-0 m-0 linkRutas {{ request()->routeIs('presentaciones') ? 'active' : '' }}" href="{{ route('presentaciones') }}">Presentaciones</a>
              </li>

            </ul>

            <div class="row">
              @if(session('tipo_usuario') === 'Administrador')
                <div class="p-2 col-md-12">
                  <a href="{{ route('admin') }}" class="btn secBgColor w-100">
                    <i class="fa-solid fa-lock"></i> Administración
                  </a>
                </div>
              @endif

              @if(session()->has('id'))
                <div class="p-2 col-md-12">
                  <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn secBgColor btnLogin w-100" type="submit"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</button>
                  </form>
                </div>
              @else
                <div class="p-2 col-md-6">
                  <button type="button" class="btn secBgColor btnLogin w-100" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="fa-solid fa-user"></i> Iniciar sesión
                  </button>
                </div>
                <div class="p-2 col-md-6">
                  <button type="button" class="btn secBgColor btnSignup w-100" data-bs-toggle="modal" data-bs-target="#registerModal">
                    <i class="fa-solid fa-right-to-bracket"></i> Registrarse
                  </button>
                </div>
              @endif
            </div>

          </div>
        </div>
      </div>
    </nav>
  </header>
  <main class="container mainContainer">
    @yield('body')
  </main>
  <footer class="footer container-fluid bgColor mt-4">
    <div class="container">
        <div class="row pb-3 pt-3">
            {{-- <h2>FOOTER!</h2> --}}
            
            <span>
                © UTN
            </span>
        </div>
    </div>
  </footer>
  @include('partials.login-sign')
  <input type="hidden" id="urlHost" name="urlHost" value="{{ url('/')}}">
</body>
</html>