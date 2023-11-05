<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="@yield('meta-description', 'UTN Osil, laboratorio de software libre')">
  <title>@yield('title')</title>

  @vite([
    "resources/js/app.js",
    "resources/css/app.css",
    
    "resources/js/librerias/popper.js",
    "resources/js/librerias/bootstrap.js",

    "resources/css/librerias/bootstrap.css"
  ])

  @yield('recursos')

  <script src="https://kit.fontawesome.com/be5e2a9675.js" crossorigin="anonymous"></script>

</head>
<body>
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
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">

              <li class="nav-item itemNav">
                <a class="nav-link {{ request()->routeIs('inicio') ? 'active' : '' }}" href="{{ route('inicio') }}"><i class="fa-solid fa-house iconoNav"></i> Inicio</a>
              </li>

              <li class="nav-item itemNav dropdown">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('congresos') ? 'active' : '' }}" href="{{ route('congresos') }}" role="button">
                  <i class="fa-regular fa-calendar-days iconoNav"></i> Congresos
                </a>
                <ul class="dropdown-menu secBgColor dropdown-menu-hover">
                  <li><a class="dropdown-item itemSubMenu" href="#">Conferencias</a></li>
                  <li><a class="dropdown-item itemSubMenu" href="#">Talleres</a></li>
                  {{-- <li>
                    <hr class="dropdown-divider">
                  </li> --}}
                </ul>
              </li>

            </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <main class="container mainContainer">
    @yield('body')
  </main>
  {{-- <footer></footer> --}}
</body>
</html>