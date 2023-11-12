<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="@yield('meta-description', 'Dashboard UTN Osil')">
  <meta name="robots" content="noindex">
  <title>@yield('title')</title>

  @viteReactRefresh
  @vite([
    "resources/css/admin.css",
    "resources/js/admin.js",
    
    "resources/js/librerias/popper.js",
    
    'resources/js/librerias/bootstrap.js',
    'resources/css/librerias/bootstrap.css'
  ])

  @yield('recursos')

  <script src="https://kit.fontawesome.com/be5e2a9675.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>


  <input type="hidden" id="urlHost" name="urlHost" value="{{ url('/')}}">
  
</body>
</html>