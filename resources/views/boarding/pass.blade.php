<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleto</title>
    <style>
        body {
            font-family: 'Verdana', sans-serif !important;
            padding: auto;
            margin: 0;
        }

        .boarding-pass {
            width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #333;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .header {
            text-align: center;
        }

        .header h5 {
            text-align: center;
            font-weight: bold;
        }

        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            max-width: 50px;
            max-height: 50px;
        }

        .intro-text {
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px; /* Reducir espacio entre las filas en .intro-text */
            color: black; /* Hacer el texto más oscuro */
            font-weight: bold; /* Hacer el texto más grueso */
        }

        .additional-text {
            text-align: right;
            font-size: 10px; /* Tamaño de fuente más pequeño */
            margin-bottom: 1px; /* Espacio mínimo entre las filas */
            color: black;
        }

        .info-container:after {
            content: "";
            display: table;
            clear: both;
        }

        .flight-info, .passenger-info {
            width: 48%; /* Cada columna ocupa el 48% del contenedor */
            float: left;
            margin-bottom: 20px;
            font-size: 10px;
        }

        .flight-info div {
            padding: 12px;
        }

        .passenger-info div {
            padding: 13px;
        }
    </style>
</head>
<body>
<div class="boarding-pass">
        <!-- Agregar imagen de la aerolínea en la parte superior izquierda -->
        <img class="logo" src="{{url('/img/logo.jpeg')}}" alt="">

        <div class="header">
            <h3>TARJETA DE EMBARQUE</h3>
        </div>

        <div class="intro-text">
            <!-- Cuatro filas de texto centrado en el inicio -->
            <div>BOARDING PASS</div>
            <div>EMPRESA: AMAZ</div>
            <div>TICKET SIN VALOR PARA CREDITO FISCAL</div>
        </div>

        <div class="additional-text">
            <!-- Dos filas adicionales alineadas a la derecha -->
            <div>Casa Matriz: Av. Bolivia N° 123</div>
            <div>TELF: (+591 3-356897)</div>
        </div>
        <hr>
        <div class="info-container">
            <div class="flight-info">
                <!-- Información del vuelo en la primera columna -->
                <div><b>FECHA:</b> {{ $service['date'] }}</div>
                <div><b>HORA:</b> {{ $service['hour'] }}</div>
                <div><b>NOMBRE:</b> {{ $service['passenger_name'] }}</div>
                <div><b>C.I.:</b> {{ $service['passenger_ci'] }}</div>
                <div><b>ORIGEN:</b> {{ $service['origin'] }}</div>
                <div><b>ASIENTO:</b> {{ $service['seat'] }}</div>
                <div><b>BAG TICKET N°:</b> {{ $service['ticket'] }}</div>
                <div><b>TOTAL KG:</b> {{ $service['total'] }}</div>
            </div>

            <div class="passenger-info">
                <div><b>VUELO N°:</b> {{ $service['flight_number'] }}</div>
                <div><b>PUERTA:</b> {{ $service['door'] }}</div>
                <div></div>
                <div></div>
                <div></div>
                <div><b>DESTINO:</b> {{ $service['destiny'] }}</div>
                <div></div>
                <div><b>CANT. EQUIPAJE:</b> {{ $service['quantity'] }}</div>
            </div>
        </div>
    </div>
</body>
</html>