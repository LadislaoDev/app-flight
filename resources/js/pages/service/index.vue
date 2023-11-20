<template>
  <div>
    <div class="boarding-pass">
        <!-- Agregar imagen de la aerolínea en la parte superior izquierda -->
        <img class="logo" src="airline_logo.png" alt="Logo de la Aerolínea">

        <div class="header">
            <h5>Pase de Abordar</h5>
        </div>

        <div class="intro-text">
            <!-- Cuatro filas de texto centrado en el inicio -->
            <div>Texto 1</div>
            <div>Texto 2</div>
            <div>Texto 3</div>
            <div>Texto 4</div>
        </div>

        <div class="additional-text">
            <!-- Dos filas adicionales alineadas a la derecha -->
            <div>Texto Adicional 1</div>
            <div>Texto Adicional 2</div>
        </div>
        <hr>
        <div class="info-container">
            <div class="flight-info">
                <!-- Información del vuelo en la primera columna -->
                <div>Vuelo: ABC123</div>
                <div>Fecha: 01 de enero de 2023</div>
                <div>Hora de salida: 10:00 AM</div>
            </div>

            <div class="passenger-info">
                <!-- Información del pasajero en la segunda columna -->
                <div>Pasajero: Juan Pérez</div>
                <div>Asiento: 10A</div>
            </div>
        </div>
    </div>
  </div>
</template>
<style scoped>
  .boarding-pass {
    width: 400px;
    margin: 20px auto;
    padding: 20px;
    border: 2px solid #333;
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
  }
</style>