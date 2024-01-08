<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="UTN Osil, laboratorio de software libre">
  <title>{{ $congreso->nombre }}</title>

  <style>
    * {
      /* font-family: 'Courier New', Courier, monospace; */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      /* font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; */
    }

    .table {
      width: 100%;
    }
  </style>
</head>
<body> 
  <h1 style="width: 100%; text-align: center;">{{ $congreso->nombre }}</h1>
  <table class="table">
    <thead>
      <tr>
        <th scope="col" style="width: 15% !important; padding: 10px; background-color: #485460; color: #fff;">Día</th>
        <th scope="col" style="width: 5% !important; padding: 10px; background-color: #485460; color: #fff;">Hora de inicio</th>
        <th scope="col" style="width: 5% !important; padding: 10px; background-color: #485460; color: #fff;">Hora de finalización</th>
        <th scope="col" style="width: 30% !important; padding: 10px; background-color: #485460; color: #fff;">Presentación</th>
        <th scope="col" style="width: 20% !important; padding: 10px; background-color: #485460; color: #fff;">Presentador</th>
        <th scope="col" style="width: 25% !important; padding: 10px; background-color: #485460; color: #fff;">Lugar</th>
      </tr>
    </thead>
    <tbody>
      @foreach($fechas as $fecha)
        @php
          $presentacionesDelDia = 0;
          foreach ($fecha as $presentaciones) {
            $presentacionesDelDia += count($presentaciones);
          }
        @endphp

        @php
          $filas = 1;
        @endphp
        @foreach($fecha as $presentaciones)
          
          @if($loop->first)
            @php
              $contadorPresentaciones = 1;
            @endphp
            @foreach($presentaciones as $presentacion)
              <tr style="{{ $filas % 2 == 0 ? 'background-color: #10ac84; color: #fff;' : 'background-color: #218c74; color: #fff;' }}">
                @php
                  $filas++;
                @endphp
                
                @if(count($presentaciones) > 1)
                  @if($loop->first)
                    <td style="padding: 10px; background-color: #ff793f; color: #fff" rowspan="{{ $presentacionesDelDia }}">{{ $presentacion->dia }}</td>
                    <td style="padding: 10px; {{ $contadorPresentaciones % 2 == 0 ? 'background-color: #ff6b6b;' : 'background-color: #ee5253;' }}" rowspan="{{ count($presentaciones) }}">{{ $presentacion->inicio }}</td>
                    <td style="padding: 10px; {{ $contadorPresentaciones % 2 == 0 ? 'background-color: #ff6b6b;' : 'background-color: #ee5253;' }}" rowspan="{{ count($presentaciones) }}">{{ $presentacion->fin }}</td>
                  @endif

                  <td style="padding: 10px; {{ $contadorPresentaciones % 2 == 0 ? 'background-color: #ff6b6b;' : 'background-color: #ee5253;' }}">{{ $presentacion->presentaciones->nombre }}</td>
                  <td style="padding: 10px; {{ $contadorPresentaciones % 2 == 0 ? 'background-color: #ff6b6b;' : 'background-color: #ee5253;' }}">{{ $presentacion->presentaciones->usuarios->nombre }}</td>
                  <td style="padding: 10px; {{ $contadorPresentaciones % 2 == 0 ? 'background-color: #ff6b6b;' : 'background-color: #ee5253;' }}">{{ $presentacion->presentaciones->lugar }}</td>
                  @php
                    $contadorPresentaciones++;
                  @endphp
                @else
                  @if($loop->first)
                    <td style="padding: 10px; background-color: #ff793f; color: #fff" rowspan="{{ $presentacionesDelDia }}">{{ $presentacion->dia }}</td>
                  @endif
                  <td style="padding: 10px;">{{ $presentacion->inicio }}</td>
                  <td style="padding: 10px;">{{ $presentacion->fin }}</td>
                  <td style="padding: 10px;">{{ $presentacion->presentaciones->nombre }}</td>
                  <td style="padding: 10px;">{{ $presentacion->presentaciones->usuarios->nombre }}</td>
                  <td style="padding: 10px;">{{ $presentacion->presentaciones->lugar }}</td>
                @endif

              </tr>
            @endforeach
          @else
            @php
              $contadorPresentaciones = 1;
            @endphp
            @foreach($presentaciones as $presentacion)
              <tr style="{{ $filas % 2 == 0 ? 'background-color: #10ac84; color: #fff;' : 'background-color: #218c74; color: #fff;' }}">
                @php
                  $filas++;
                @endphp

                @if(count($presentaciones) > 1)
                  @if($loop->first)
                    <td style="padding: 10px; {{ $contadorPresentaciones % 2 == 0 ? 'background-color: #ff6b6b;' : 'background-color: #ee5253;' }}" rowspan="{{ count($presentaciones) }}">{{ $presentacion->inicio }}</td>
                    <td style="padding: 10px; {{ $contadorPresentaciones % 2 == 0 ? 'background-color: #ff6b6b;' : 'background-color: #ee5253;' }}" rowspan="{{ count($presentaciones) }}">{{ $presentacion->fin }}</td>
                  @endif

                  <td style="padding: 10px; {{ $contadorPresentaciones % 2 == 0 ? 'background-color: #ff6b6b;' : 'background-color: #ee5253;' }}">{{ $presentacion->presentaciones->nombre }}</td>
                  <td style="padding: 10px; {{ $contadorPresentaciones % 2 == 0 ? 'background-color: #ff6b6b;' : 'background-color: #ee5253;' }}">{{ $presentacion->presentaciones->usuarios->nombre }}</td>
                  <td style="padding: 10px; {{ $contadorPresentaciones % 2 == 0 ? 'background-color: #ff6b6b;' : 'background-color: #ee5253;' }}">{{ $presentacion->presentaciones->lugar }}</td>
                  @php
                    $contadorPresentaciones++;
                  @endphp
                @else
                  <td style="padding: 10px;">{{ $presentacion->inicio }}</td>
                  <td style="padding: 10px;">{{ $presentacion->fin }}</td>
                  <td style="padding: 10px;">{{ $presentacion->presentaciones->nombre }}</td>
                  <td style="padding: 10px;">{{ $presentacion->presentaciones->usuarios->nombre }}</td>
                  <td style="padding: 10px;">{{ $presentacion->presentaciones->lugar }}</td>
                @endif
              </tr>
            @endforeach
          @endif

        @endforeach

      @endforeach
    </tbody>
  </table>

</body>
</html>