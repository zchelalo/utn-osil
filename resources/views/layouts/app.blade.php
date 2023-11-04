<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="@yield('meta-description', 'UTN Osil, laboratorio de software libre')">
  <title>@yield('title')</title>
</head>
<body>
  {{-- <header></header> --}}
  <main>
    @yield('body')
  </main>
  {{-- <footer></footer> --}}
</body>
</html>