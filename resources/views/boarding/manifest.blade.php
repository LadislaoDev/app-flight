<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Reporte</title>
  <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet"> -->
  <style>
    .container {
      max-width: 100%;
      margin: auto;
      font-family: 'Roboto', sans-serif !important;
    }

    .light-table {
      width: 100%;  
      padding-top: 0;
      padding-bottom: 0;
      margin-bottom: 5px;
      text-align: left;
    }

    .leftdiv {
      float: left;
      position: relative;
      width: 33%; 
    }

    .leftdiv p {
      display: block;
      width: 75%;
      /* margin: 0 auto !important; */
    }

    .leftdivcontainer {
      vertical-align: middle;
      width: 100%;
      text-align: center;
    }

    .clearfix:after {
      clear: both;
    }

    .clearfix:before,
    .clearfix:after {
      content: " ";
      display: table;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    table th,
    table td {
      border: 1px solid #807979;
      padding: 0.625em;
      text-align: center;
      font-weight: bold;
    }

    table tbody tr {
      border: 1px solid #ddd;
      font-size: 13px;
      background-color: #f2f4f8;
    }

    table thead th {
      padding-top: 6px;
      padding-bottom: 6px;
      background-color: #c5e8ef;
      color: black;
      text-transform: uppercase;
      font-size: 0.85em;
    }

    .table-container {
      display: inline-block;
      width: 25%;
      margin-top: 20px;
    }

    .styled-table {
      width: 100%;
      border-collapse: collapse;
    }

    .styled-table th, .styled-table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }

    .columna {
      width: 33%;
      float: left;
      padding: 15px;
      box-sizing: border-box;
    }

    .label {
            float: left;
            width: 80px; /* Ancho del label según sea necesario */
            font-weight: bold;
        }

        .styled-input {
            float: left;
            width: calc(100% - 80px); /* Ancho del input según el label */
            border: 1px solid #ddd;
            padding: 8px;
            border-radius: 4px;
        }

        .column {
                float: left;
                width: 100%;
                padding: 10px;
            }

            .row:after {
                content: "";
                display: table;
                clear: both;
            }
  </style>
</head>
<body>
  <div class="container">
    <div class="light-table">
      <div class="leftdivcontainer clearfix">
        <div class="leftdiv">
          <div style="border: 2px solid #287729; border-radius: 7px; text-align: left; width: 60%; padding: 10px;">
            <span style="color: #000; font-weight: bold; font-size: 15px; letter-spacing: 1px;">SUCURSAL: Santa Cruz de la Sierra</span>
          </div>
        </div>
        <div class="leftdiv" style="margin-top: 0;">
          <div style="color: #000; font-size: 22px; font-weight: bold; text-decoration: underline;">MANIFIESTO DE PASAJEROS</div>
        </div>
        <div class="leftdiv">
          <div style="text-align: right;"><img src="{{url('/img/logo2.jpg')}}" style="width:80px; height:80px;"></div>
          <div style="text-align: right;"><span style="font-weight: bold;">Emitido: </span>{{ date('d/m/Y') }}</div>
        </div>
      </div>
    </div>

    <div class="columna">
      <div class="row">
        <div class="column">
          <div>
            <div style="display: inline-block;"><b>VUELO N° / FLIGHT N° :</b></div>
            <div style="display: inline-block; border: 2px solid #707070; border-radius: 7px; width: 200px; padding: 5px;">{{ $data[0]['flight_number'] }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="columna">
      <div class="row">
        <div class="column">
          <div>
            <div style="display: inline-block;"><b>FECHA / DATE:</b></div>
            <div style="display: inline-block; border: 2px solid #707070; border-radius: 7px; width: 200px; padding: 5px;">{{ $data[0]['date'] }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="columna">
      <div class="row">
        <div class="column">
          <div>
            <div style="display: inline-block;"><b>HORA / HOUR:</b></div>
            <div style="display: inline-block; border: 2px solid #707070; border-radius: 7px; width: 200px; padding: 5px;">{{ $data[0]['hour'] }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="columna">
      <div class="row">
        <div class="column">
          <div>
            <div style="display: inline-block;"><b>ORIGEN /FROM :</b></div>
            <div style="display: inline-block; border: 2px solid #707070; border-radius: 7px; width: 200px; padding: 5px;">{{ $data[0]['origin'] }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="columna">
      <div class="row">
        <div class="column">
          <div>
            <div style="display: inline-block;"><b>DESTINO / TO:</b></div>
            <div style="display: inline-block; border: 2px solid #707070; border-radius: 7px; width: 200px; padding: 5px;">{{ $data[0]['destiny'] }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="clearfix"></div>

    <table>
      <thead>
        <tr>
          <th width="50px">NRO</th>
          <th width="50px">NOMBRES Y APELLIDOS</th>
          <th width="50px">EDAD</th>
          <th width="50px">PESO PAX</th>
          <th width="50px">PAS. KG</th>
          <th width="50px">N° TICKET</th>
          <th width="50px">ASIENTO/SEAT</th>
          <th width="50px">PIEZA</th>
          <th width="50px">PESO</th>
        </tr>
      </thead>
      <tbody>
        @php
          $totalPeso = 0;
          $totalAdultos = 0;
          $totalMenores = 0;
          $totalInfantes = 0;
          $totalPieza = 0;
          $totalPesoEquipaje = 0;
        @endphp

        @foreach($data as $item)
          <tr style="page-break-inside: avoid;">
            <td class="text-content">{{ $item['id'] }}</td>
            <td class="text-content">{{ $item['passenger_name'] }}</td>
            <td class="text-content">{{ $item['age'] }}</td>
            <td class="text-content">{{ $item['weight'] }}</td>
            <td class="text-content">{{ $item['kg'] }}</td>
            <td class="text-content">{{ $item['ticket'] }}</td>
            <td class="text-content">{{ $item['seat'] }}</td>
            <td class="text-content">{{ $item['quantity'] }}</td>
            <td class="text-content">{{ $item['total'] }}</td>
          </tr>

          @php
            $totalPeso += ($item['weight'] + $item['kg']);

            if ($item['age'] == 'ADULTO') {
              $totalAdultos += 1;
            } elseif ($item['age'] == 'MENORES') {
              $totalMenores += 1;
            } elseif ($item['age'] == 'INFANTE') {
              $totalInfantes += 1;
            }

            $totalPieza += $item['quantity'];
            $totalPesoEquipaje += $item['total'];
          @endphp
        @endforeach
      </tbody>
    </table>

    <div class="table-container" style="float: left;">
      <table class="styled-table">
        <tbody>
          <tr>
            <td>TOTAL PESO</td>
            <td>{{ $totalPeso }}</td>
          </tr>
          <tr>
            <td>TOTAL ADULTOS</td>
            <td>{{ $totalAdultos }}</td>
          </tr>
          <tr>
            <td>TOTAL MENORES</td>
            <td>{{ $totalMenores }}</td>
          </tr>
          <tr>
            <td>TOTAL INFANTES</td>
            <td>{{ $totalInfantes }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="table-container" style="float: right;">
      <table class="styled-table">
        <tbody>
          <tr>
            <td>TOTAL PIEZA</td>
            <td>{{ $totalPieza }}</td>
          </tr>
          <tr>
            <td>TOTAL PESO EQUIPAJE</td>
            <td>{{ $totalPesoEquipaje }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
