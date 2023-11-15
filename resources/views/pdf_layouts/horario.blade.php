<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="UTN Osil, laboratorio de software libre">
  <title>{{ $congreso->nombre }}</title>

  <style>
    .table {
      width: 100%;
    }
  </style>
</head>
<body> 
  <h1>{{ $congreso->nombre }}</h1>
  <table class="table">
    <thead>
      <tr>
        <th scope="col" style="width: 20%; padding: 10px; background-color: #485460; color: #fff;">Día</th>
        <th scope="col" style="width: 20%; padding: 10px; background-color: #485460; color: #fff;">Hora de inicio</th>
        <th scope="col" style="width: 10%; padding: 10px; background-color: #485460; color: #fff;">Hora de finalización</th>
        <th scope="col" style="width: 50%; padding: 10px; background-color: #485460; color: #fff;">Presentación</th>
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

        @foreach($fecha as $presentaciones)
          
          @if($loop->first)
            @foreach($presentaciones as $presentacion)
              <tr style="{{ $loop->iteration % 2 == 0 ? 'background-color: #10ac84; color: #fff;' : 'background-color: #20bf6b; color: #fff;' }}">
                
                @if(count($presentaciones) > 1)
                  @if($loop->first)
                    <td style="padding: 10px; background-color: #ff793f; color: #fff" rowspan="{{ $presentacionesDelDia }}">{{ $presentacion->dia }}</td>
                    <td style="padding: 10px;" rowspan="{{ count($presentaciones) }}">{{ $presentacion->inicio }}</td>
                    <td style="padding: 10px;" rowspan="{{ count($presentaciones) }}">{{ $presentacion->fin }}</td>
                  @endif
                  <td style="padding: 10px;">{{ $presentacion->presentaciones->nombre }}</td>
                @else
                  @if($loop->first)
                    <td style="padding: 10px; background-color: #ff793f; color: #fff" rowspan="{{ $presentacionesDelDia }}">{{ $presentacion->dia }}</td>
                  @endif
                  <td style="padding: 10px;">{{ $presentacion->inicio }}</td>
                  <td style="padding: 10px;">{{ $presentacion->fin }}</td>
                  <td style="padding: 10px;">{{ $presentacion->presentaciones->nombre }}</td>
                @endif

              </tr>
            @endforeach
          @else
            @foreach($presentaciones as $presentacion)
              <tr style="{{ $loop->iteration % 2 == 0 ? 'background-color: #10ac84; color: #fff;' : 'background-color: #20bf6b; color: #fff;' }}">
                @if(count($presentaciones) > 1)
                  @if($loop->first)
                    <td style="padding: 10px;" rowspan="{{ count($presentaciones) }}">{{ $presentacion->inicio }}</td>
                    <td style="padding: 10px;" rowspan="{{ count($presentaciones) }}">{{ $presentacion->fin }}</td>
                  @endif
                  <td style="padding: 10px;">{{ $presentacion->presentaciones->nombre }}</td>
                @else
                  <td style="padding: 10px;">{{ $presentacion->inicio }}</td>
                  <td style="padding: 10px;">{{ $presentacion->fin }}</td>
                  <td style="padding: 10px;">{{ $presentacion->presentaciones->nombre }}</td>
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