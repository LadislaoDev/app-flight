<template>
  <div class="container mt-4">
    <loading :active.sync="loading" :is-full-page="true" color="#08197c"></loading>
    <div class="card">
      <div class="card-header text-center">
        <h2 class="fw-bold">MANIFIESTO DE PASAJEROS</h2>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <label for="fecha" class="form-label fw-bold">Fecha Registro Check In</label>
            <input type="date" class="form-control" v-model="date" />
          </div>
          <div class="col-md-3">
            <label for="fecha" class="form-label fw-bold">N° VUELO / FLIGHT N° :</label>
            <div class="d-table-cell w-100 me-2">
              <input type="text" class="form-control" v-model="flight_number" />
            </div>
            <div class="d-table-cell align-middle ml-2">
              <button @click="getCheckinManifest" type="button" class="btn btn-primary btn-sm btn-height ms-1">
                <fa icon="search" fixed-width />
              </button>
            </div>
            <div class="d-table-cell align-middle ml-2">
              <button :disabled="isBotonDeshabilitado" @click="downloadManifest" type="button" class="btn btn-success btn-sm btn-height ms-1">
                <fa icon="download" fixed-width />
              </button>
            </div>
          </div>
        </div>
        <hr>
        <div v-if="items.length > 0">
          <div class="mt-3 row">
            <label class="col-md-1 col-form-label text-md-end fw-bold fz-12">VUELO N° / FLIGHT N° :</label>
            <div class="col-md-3">
              <input :value="item.flight_number" disabled class="form-control" type="text">
            </div>

            <label class="col-md-1 col-form-label text-md-end fw-bold fz-12">FECHA / DATE:</label>
            <div class="col-md-3">
              <input :value="item.date" disabled class="form-control" type="text">
            </div>

            <label class="col-md-1 col-form-label text-md-end fw-bold fz-12">HORA / HOUR:</label>
            <div class="col-md-3">
              <input :value="item.hour" disabled class="form-control" type="text">
            </div>
          </div>

          <div class="mt-3 row">
            <label class="col-md-1 col-form-label text-md-end fw-bold fz-12">ORIGEN /FROM :</label>
            <div class="col-md-3">
              <input :value="item.origin" disabled class="form-control" type="text">
            </div>

            <label class="col-md-1 col-form-label text-md-end fw-bold fz-12">DESTINO / TO:</label>
            <div class="col-md-3">
              <input :value="item.destiny" disabled class="form-control" type="text">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col">
              <table class="table table-bordered table-striped table-hover">
                <thead class="table-info">
                  <tr>
                    <th scope="col">NRO</th>
                    <th scope="col">NOMBRES Y APELLIDOS</th>
                    <th scope="col">EDAD</th>
                    <th scope="col">PESO PAX</th>
                    <th scope="col">PAS. KG</th>
                    <th scope="col">N° TICKET</th>
                    <th scope="col">ASIENTO/SEAT</th>
                    <th scope="col">PIEZA</th>
                    <th scope="col">PESO</th>
                    <th scope="col">OPCIONES</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in items" :key="item.id">
                    <td>{{ item.flight_number }}</td>
                    <td>{{ item.passenger.names }}</td>
                    <td>{{ item.age }}</td>
                    <td>{{ item.weight }}</td>
                    <td>{{ item.kg }}</td>
                    <td>{{ item.ticket }}</td>
                    <td>{{ item.seat }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>{{ item.total }}</td>
                    <td>
                      <button @click="generatePDF(item.id)" type="button" class="btn btn-secondary btn-sm">
                        <fa icon="download" fixed-width />
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-4">
              <table class="custom-table w-100">
                <tbody>
                  <tr>
                    <td><b>TOTAL PESO</b></td>
                    <td class="text-center">{{ totalPesoPax }}</td>
                  </tr>
                  <tr>
                    <td><b>TOTAL ADULTOS</b></td>
                    <td class="text-center">{{ cantidadAdultos }}</td>
                  </tr>
                  <tr>
                    <td><b>TOTAL MENORES</b></td>
                    <td class="text-center">{{ cantidadMenores }}</td>
                  </tr>
                  <tr>
                    <td><b>TOTAL INFANTES</b></td>
                    <td class="text-center">{{ cantidadInfantes }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-4 ms-auto">
              <table class="custom-table w-100">
                <tbody>
                  <tr>
                    <td><b>TOTAL PIEZA</b></td>
                    <td class="text-center">{{ totalQuantity }}</td>
                  </tr>
                  <tr>
                    <td><b>TOTAL PESO EQUIPAJE</b></td>
                    <td class="text-center">{{ totalKg }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'

export default {
  middleware: 'auth',
  data() {
    return {
      loading: false,
      date: '',
      flight_number: '',
      items: [],
      item: null,
    };
  },

  computed: {
    isBotonDeshabilitado() {
      return !this.items.length > 0 ? true : false
    },

    totalPesoPax() {
      return this.items.reduce((total, item) => total + (item.weight + item.kg), 0);
    },

    totalQuantity() {
      return this.items.reduce((total, item) => total + item.quantity, 0);
    },

    totalKg() {
      return this.items.reduce((total, item) => total + item.total, 0);
    },

    cantidadAdultos() {
      return this.items.filter(item => item.age === 'ADULTO').length;
    },

    cantidadMenores() {
      return this.items.filter(item => item.age === 'MENORES').length;
    },

    cantidadInfantes() {
      return this.items.filter(item => item.age === 'INFANTE').length;
    },
  },

  components: {
    Loading
  },

  methods: {
    async getCheckinManifest() {
      this.loading = true

      try {
        axios({
          method: 'post',
          url: '/api/services/manifest',
          data: {date: this.date, flight_number: this.flight_number}
        })
          .then((response) => {
            this.items = response.data.data
            this.item = this.items[0]
          })
          .catch((error) => {
            this.loading = false
          })
          .finally(() => {
            this.loading = false
          })
      } catch (err) {
        this.loading = false
      }
    },

    async downloadManifest() {
      this.loading = true

      try {
        axios({
          method: 'post',
          url: `/api/manifest`,
          responseType: 'arraybuffer',
          data: {date: this.date, flight_number: this.flight_number}
        })
          .then((response) => {
            let file = new Blob([response.data], {type: 'application/pdf'})
            let fileUrl = URL.createObjectURL(file)
            window.open(fileUrl) 
            this.loading = false
          })
          .catch((error) => {
            this.loading = false
          })
          .finally(() => {
            this.loading = false
          })
      } catch (err) {
        this.loading = false
      }
    },

    async generatePDF(id) {
      this.loading = true

      try {
        axios({
          method: 'get',
          url: `/api/services/${id}`,
          responseType: 'arraybuffer'
        })
          .then((response) => {
            let file = new Blob([response.data], {type: 'application/pdf'})
            let fileUrl = URL.createObjectURL(file)
            window.open(fileUrl) 
            this.loading = false
          })
          .catch((error) => {
            this.loading = false
          })
          .finally(() => {
            this.loading = false
          })
      } catch (err) {
        this.loading = false
      }
    },
  }
};
</script>

<style scoped>
.btn-height {
  height: 37px;
}
.fz-12 {
  font-size: 12px;
}
.custom-table {
  border-collapse: collapse;
  margin-top: 10px;
}

.custom-table th,
.custom-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.custom-table th {
  background-color: #f2f2f2;
}
</style>
