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

    "resources/js/app.js",
    "resources/js/form.js",
    "resources/css/app.css",
    "resources/css/form.css",
    
    // 'resources/sass/app.scss',

    "resources/js/librerias/popper.js",
    
    'resources/js/librerias/bootstrap.js',
    'resources/js/librerias/sweetalert2.js',
    'resources/css/librerias/bootstrap.css',
    'resources/css/librerias/sweetalert2.css'
  ])

  @yield('recursos')

  <script src="https://kit.fontawesome.com/be5e2a9675.js" crossorigin="anonymous"></script>

</head>
<body>
  @if(session('status'))
    <script>
        window.addEventListener('load', function () {
          Swal.fire({
            text: "{{ session('status') }}",
            icon: 'info',
            confirmButtonText: 'Cerrar'
          });
        }, false);
    </script>
  @endif
  {{-- <div id="root"></div> --}}
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
              <div class="p-2 col-md-6">
                <button type="button" class="btn secBgColor btnLogin w-100" data-bs-toggle="modal" data-bs-target="#loginModal">
                  Iniciar sesión
                </button>
              </div>
              <div class="p-2 col-md-6">
                <button type="button" class="btn secBgColor btnSignup w-100" data-bs-toggle="modal" data-bs-target="#registerModal">
                  Registrarse
                </button>
              </div>
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
</body>
</html>