<template>
    <div>
      <loading :active.sync="loading" :is-full-page="true" color="#08197c"></loading>
      <b-modal
        v-model="showModalDelete"
        :header-bg-variant="'secondary'"
        size="lg"
        no-close-on-backdrop
        hide-footer
      >
        <template v-slot:modal-header="{ close }">
          <h5 class="text-white">Eliminar Registro</h5>
          <b-button squared size="sm" variant="primary" @click="closeModalDelete">X</b-button>
        </template>
        <strong class="fs-4">Realmente desea eliminar este registro?</strong>
        <hr>
        <div class="d-flex justify-content-end">
          <button @click="closeModalDelete" type="button" class="btn btn-secondary me-2"><fa icon="times-circle" fixed-width /> Cancelar</button>
          <button :disabled="loadingDelete" @click="deleteFlight" type="button" class="btn btn-primary">
            <b-spinner v-if="loadingDelete" small variant="light"></b-spinner>
            <fa v-else icon="check-circle" fixed-width />
            ELIMINAR
          </button>
        </div>
      </b-modal>
      <b-modal
        v-model="showModalState"
        :header-bg-variant="'secondary'"
        size="lg"
        no-close-on-backdrop
        hide-footer
      >
        <template v-slot:modal-header="{ close }">
          <h5 class="text-white">Completar Proceso</h5>
          <b-button squared size="sm" variant="primary" @click="closeModalState">X</b-button>
        </template>
        <strong class="fs-4">Realmente desea completar el proceso de vuelo?</strong>
        <hr>
        <div class="d-flex justify-content-end">
          <button @click="closeModalState" type="button" class="btn btn-secondary me-2"><fa icon="times-circle" fixed-width /> Cancelar</button>
          <button :disabled="loadingState" @click="completeState" type="button" class="btn btn-primary">
            <b-spinner v-if="loadingState" small variant="light"></b-spinner>
            <fa v-else icon="check-circle" fixed-width />
            ACEPTAR
          </button>
        </div>
      </b-modal>
      <b-modal
        v-model="showModalFlight"
        :header-bg-variant="'secondary'"
        size="lg"
        no-close-on-backdrop
        hide-footer
      >
        <template v-slot:modal-header="{ close }">
          <h5 class="text-white">
            <span v-if="flight.id">Modificar Vuelo</span>
            <span v-else>Registrar Vuelo</span>
          </h5>
          <b-button squared size="sm" variant="primary" @click="closeModalFlight">X</b-button>
        </template>
        <form @submit.prevent="registerFlight">
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end fw-bold">Fecha:</label>
            <div class="col-md-7">
              <b-form-group label-for="date" :invalid-feedback="errors.first('date')" :state="!errors.has('date')">
                <b-form-input
                  v-model="flight.date"   
                  :state="errors.has('date') ? false : null"
                  v-validate="'required'"
                  data-vv-name="date"
                  data-vv-as="fecha"
                  type="date"
                ></b-form-input>
              </b-form-group>
            </div>
          </div>
          
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end fw-bold">N° de Vuelo:</label>
            <div class="col-md-7">
              <b-form-group label-for="number" :invalid-feedback="errors.first('number')" :state="!errors.has('number')">
                <b-form-input
                  v-model="flight.number"   
                  :state="errors.has('number') ? false : null"
                  v-validate="'required'"
                  data-vv-name="number"
                  data-vv-as="n° de vuelo"
                  type="text"
                ></b-form-input>
              </b-form-group>
            </div>
          </div>
  
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end fw-bold">Origen:</label>
            <div class="col-md-7">
              <b-form-group label-for="origin" :invalid-feedback="errors.first('origin')" :state="!errors.has('origin')">
                <select 
                  v-model="flight.origin" 
                  class="form-select"
                  :state="errors.has('origin') ? false : null"
                  v-validate="'required'"
                  data-vv-name="origin"
                  data-vv-as="origen"
                >
                  <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                </select>
              </b-form-group>
            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end fw-bold">Destino:</label>
            <div class="col-md-7">
              <b-form-group label-for="destiny" :invalid-feedback="errors.first('destiny')" :state="!errors.has('destiny')">
                <select 
                  v-model="flight.destiny" 
                  class="form-select"
                  :state="errors.has('destiny') ? false : null"
                  v-validate="'required'"
                  data-vv-name="destiny"
                  data-vv-as="destino"
                >
                  <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                </select>
              </b-form-group>
            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end fw-bold">Hora:</label>
            <div class="col-md-7">
              <b-form-group label-for="hour" :invalid-feedback="errors.first('hour')" :state="!errors.has('hour')">
                <b-form-input
                  v-model="flight.hour"   
                  :state="errors.has('hour') ? false : null"
                  v-validate="'required'"
                  data-vv-name="hour"
                  data-vv-as="hora"
                  type="time"
                ></b-form-input>
              </b-form-group>
            </div>
          </div>
          <hr>
          <div class="d-flex justify-content-end">
            <button @click="closeModalFlight" type="button" class="btn btn-secondary me-2"><fa icon="times-circle" fixed-width /> Cancelar</button>
            <button :disabled="loadingForm" @click="registerFlight" type="button" class="btn btn-primary">
              <b-spinner v-if="loadingForm" small variant="light"></b-spinner>
              <fa v-else icon="check-circle" fixed-width />
              <span v-if="flight.id">MODIFICAR</span>
              <span v-else>REGISTRAR</span>  
            </button>
          </div>
        </form>
      </b-modal>
      <div class="container mt-4">
        <div class="card">
          <div class="card-header">
            <h2 class="fw-bold">LISTA DE VUELOS</h2>
          </div>
          <div class="card-body">
            <div class="d-flex flex-sm-row flex-column bg-custom">
              <div class="mr-auto p-2">
                <b-button @click="openModalFlight" size="sm" variant="primary" class="ml-2">
                  <fa icon="plus-circle" fixed-width /> Registrar Nuevo
                </b-button>
              </div>
              <div class="p-2 ms-auto">
                <b-form-group>
                  <label class="d-inline-block" for="btn-radios-sort">
                    <strong>Ordenar por fecha: &nbsp;</strong>
                  </label>
                  <b-form-radio-group
                    id="btn-radios-sort"
                    v-model="sort"
                    :options="sortItems"
                    button-variant="outline-primary"
                    size="sm"
                    name="radio-btn-outline"
                    buttons
                  ></b-form-radio-group>
                </b-form-group>
              </div>
              <div class="p-2">
                <b-button @click="getFlights" title="Actualizar Tabla" size="sm" variant="dark" class="mr-2">
                  <fa icon="reply-all" fixed-width /> Recargar
                </b-button>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <!-- <pre>{{ $data }}</pre> -->
                <b-table class="text-center" thead-class="bg-primary text-white" :busy="isBusy" fixed striped hover small :items="records" :fields="columns" responsive="sm" stacked="sm" :current-page="currentPage" show-empty>
                  <template v-slot:empty="scope">
                    <div class="text-center">
                      <i class="fa fa-search-minus fa-3x" aria-hidden="true"></i>
                      <h6>No tienes vuelos registrados</h6>
                    </div>
                  </template>
                  <template #table-busy>
                    <div class="text-center text-primary my-2">
                      <b-spinner class="align-middle"></b-spinner>
                    </div>
                  </template>
                  <template v-slot:head(id)="data">
                    <span>{{ data.label.toUpperCase() }}</span>
                  </template>
                  <template v-slot:head(date)="data">
                    <span>{{ data.label.toUpperCase() }}</span>
                  </template>
                  <template v-slot:head(number)="data">
                    <span>{{ data.label.toUpperCase() }}</span>
                  </template>
                  <template v-slot:head(origin)="data">
                    <span>{{ data.label.toUpperCase() }}</span>
                  </template>
                  <template v-slot:head(destiny)="data">
                    <span>{{ data.label.toUpperCase() }}</span>
                  </template>
                  <template v-slot:head(hour)="data">
                    <span>{{ data.label.toUpperCase() }}</span>
                  </template>
                  <template v-slot:head(state)="data">
                    <span>{{ data.label.toUpperCase() }}</span>
                  </template>
                  <template v-slot:head(created)="data">
                    <span>{{ data.label.toUpperCase() }}</span>
                  </template>
                  <template v-slot:head(updated)="data">
                    <span>{{ data.label.toUpperCase() }}</span>
                  </template>
                  <template v-slot:head(opciones)="data">
                    <span>{{ data.label.toUpperCase() }}</span>
                  </template>
                  <template v-slot:cell(id)="data">
                    <strong>{{ data.value }}</strong>
                  </template>
                  <template v-slot:cell(date)="data">
                    <strong>{{ data.value }}</strong>
                  </template>
                  <template v-slot:cell(number)="data">
                    <strong>{{ data.value }}</strong>
                  </template>
                  <template v-slot:cell(origin)="data">
                    <strong>{{ data.value }}</strong>
                  </template>
                  <template v-slot:cell(destiny)="data">
                    <strong>{{ data.value }}</strong>
                  </template>
                  <template v-slot:cell(hour)="data">
                    <strong>{{ data.value }}</strong>
                  </template>
                  <template v-slot:cell(state)="data">
                    <span v-html="templateStatus(data.value)"></span>
                  </template>
                  <template v-slot:cell(created)="data">
                    <strong>{{ data.value }}</strong>
                  </template>
                  <template v-slot:cell(updated)="data">
                    <strong>{{ data.value }}</strong>
                  </template>
                  <template v-slot:cell(opciones)="row">
                    <b-button @click="editFlight(row.item)" size="sm" class="mr-2" variant="dark">
                      <fa icon="edit" fixed-width />
                    </b-button>
                    <b-button @click="openModalDelete(row.item)" size="sm" class="mr-2" variant="warning">
                      <fa icon="ban" fixed-width />
                    </b-button>
                    <b-button :disabled="row.item.state == 'COMPLETADO'" @click="openModalState(row.item)" size="sm" class="mr-2" variant="success">
                      <fa icon="check-circle" fixed-width />
                    </b-button>
                  </template>
                </b-table>
              </div>
            </div>
            <div class="row justify-content-between">
              <div class="col-md-4">
                <b-pagination :total-rows="totalItems" v-model="currentPage" :per-page="perPage">
                  <template v-slot:first-text><fa icon="step-backward" fixed-width /></template>
                  <template v-slot:prev-text><fa icon="arrow-left" fixed-width /></template>
                  <template v-slot:next-text><fa icon="arrow-right" fixed-width /></template>
                  <template v-slot:last-text><fa icon="step-forward" fixed-width /></template>
                </b-pagination>
              </div>
              <div class="col-md-3">
                <b-form-group
                  class="text-bold"
                  label="ítems por página"
                  label-cols-sm="4"
                  label-cols-md="4"
                  label-cols-lg="4"
                  label-align-sm="right"
                  label-size="sm"
                >
                  <v-select v-model="perPage" :searchable="false" :clearable="false" :options="pageOptions"></v-select>
                </b-form-group>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  <script>
  import axios from 'axios'
  import Loading from 'vue-loading-overlay'
  import 'vue-loading-overlay/dist/vue-loading.css'
  
  export default {
    data() {
      return {
        loading: false,
        showModalFlight: false,
        showModalDelete: false,
        showModalState: false,
        loadingForm: false,
        loadingDelete: false,
        loadingState: false,
        flight: {
          id: null,
          number: '',
          date: '',
          origin: '',
          destiny: '',
          hour: '',
        },
        flightId: null,
        records: [],
        isBusy: false,
        columns: [
          { key: 'id', label: 'Nº'},
          { key: 'number', label: 'N° de Vuelo'},
          { key: 'date', label: 'fecha'},
          { key: 'origin', label: 'Origen'},
          { key: 'destiny', label: 'Destino'},
          { key: 'hour', label: 'Hora'},
          { key: 'state', label: 'Estado'},
          { key: 'created', label: 'Registrado'},
          { key: 'updated', label: 'Actualizado'},
          'opciones',
        ],
        sort: 'desc',
        sortItems: [
          { text: 'ASC ▲', value: 'asc' },
          { text: 'DESC ▼', value: 'desc' },
        ],
        pageOptions: [5, 10, 15, 20],
        currentPage: 1,
        perPage: 10,
        totalItems: 0,
        cities: [],
      }
    },
  
    watch: {
      sort: {
        handler: function(value) {
          this.getFlights()
        }
      },
      currentPage: {
        handler: function(value) {
          this.getFlights()
        }
      },
      perPage: {
        handler: function(value) {
          this.getFlights()
        }
      }
    },
  
    components: {
      Loading
    },
  
    created() {
      Promise.all([this.getFlights(), this.listCities()])
      .then(() =>{
        this.loading = false
      })
    },
  
    methods: {
      editFlight(row) {
        this.flight.id = row.id
        this.flight.number = row.number
        this.flight.date = row.date_edit
        this.flight.origin = row.origin_id
        this.flight.destiny = row.destiny_id
        this.flight.hour = row.hour
        this.openModalFlight()
      },
  
      openModalFlight() {
        this.showModalFlight = true  
      },
  
      closeModalFlight() {
        this.showModalFlight = false
        this.cleanFlight()
      },
  
      openModalDelete(row) {
        this.flightId = row.id
        this.showModalDelete = true
      },
  
      closeModalDelete() {
        this.flightId = null
        this.showModalDelete = false
      },

      openModalState(row) {
        this.flightId = row.id
        this.showModalState = true
      },
  
      closeModalState() {
        this.flightId = null
        this.showModalState = false
      },
  
      cleanFlight() {
        this.flight = {
          id: null,
          number: '',
          date: '',
          origin: '',
          destiny: '',
          hour: '',
        }
      },

      templateStatus(status) {
        switch (status) {
          case 'PENDIENTE':
            return (
              "<span class='badge bg-secondary'>PENDIENTE</span>"
            );
            break;
          case 'COMPLETADO':
            return (
              "<span class='badge bg-info text-dark'>COMPLETADO</span>"
            );
            break;
          default:
            return (
              "<span class='badge bg-info text-dark'>COMPLETADO</span>"
            );
        }
      },
  
      async getFlights() {
        this.isBusy = true
        try {
          axios({
            method: 'get',
            url: this.buildURL(),
          })
          .then((response) => {
            if (response.status == 200) {
              this.records = response.data.data
              this.totalItems = response.data.meta.total
              this.isBusy = false
            }
          })
          .catch((error) => {
            this.isBusy = false
          })
          .finally(() => {
            this.isBusy = false
          })
        } catch (err) {
          this.isBusy = false
        }
      },
  
      async registerFlight() {
        this.$validator.errors.clear()
        this.loadingForm = true
  
        if (this.flight.id) {
          axios({
            method: 'put',
            url: `/api/update/flight/${this.flight.id}`,
            data: this.flight
          })
          .then((response) => {
            this.showModalFlight = false
            this.cleanFlight()
            this.getFlights()
  
            this.loadingForm = false
          })
          .catch((error) => {
            if(error.response.status === 422) this.$setErrorsFromResponse(error.response.data)
            this.loadingForm = false
          })
        } else {
          axios({
            method: 'post',
            url: '/api/register/flight',
            data: this.flight
          })
          .then((response) => {
            this.showModalFlight = false
            this.cleanFlight()
            this.getFlights()
  
            this.loadingForm = false
          })
          .catch((error) => {
            if(error.response.status === 422) this.$setErrorsFromResponse(error.response.data)
            this.loadingForm = false
          })
        }
      },

      async completeState() {
        this.loadingState = true
        axios({
          method: 'get',
          url: `/api/complete/flight/${this.flightId}`,
        })
        .then((response) => {
          if (response.data.success) {
            this.closeModalState()
            this.getFlights()
          }
          
          this.loadingState = false
        })
        .catch((error) => {
          this.loadingState = false
        })
      },
  
      async deleteFlight() {
        this.loadingDelete = true
        axios({
          method: 'delete',
          url: `/api/delete/flight/${this.flightId}`,
        })
        .then((response) => {
          if (response.data.success) {
            this.closeModalDelete()
            this.getFlights()
          }
          
          this.loadingDelete = false
        })
        .catch((error) => {
          this.loadingDelete = false
        })
      },

      listCities() {
        axios
          .get('/api/list/cities')
          .then((response) => {
            this.cities = response.data.data
          })
      },
  
      buildURL() {
        let sort = `?sort=${this.sort}`
        let current_page = `&page=${this.currentPage}`
        let per_page = `&per_page=${this.perPage}`
        return `/api/flights${sort}${current_page}${per_page}`
      },
    }
  }
  </script>
  <style scoped>
  .fieldset {
    width: 100%;
    background: #f5f9ff;
    border: 2px groove threedface;
    margin: 2px;
    margin-top: 10px;
    position: relative;
    padding: 15px 12px 10px;
  }
  
  .fieldset .legend {
    position: absolute;
    top: -11px;
    left: 11px;
    background: white;
    padding-left: 2px;
    padding-right: 2px;
  }
  
  >>> .text-bold .form-row legend {
    font-weight: bold;
  }
  
  >>> .pagination .page-item.active .page-link {
    background-color: #375bb5;
    border-color: #97b4ff;
  }
  
  >>> .page-link:focus {
    box-shadow: 0 0 0 0.2rem #97b4ff;
  }
  
  >>> .bg-primary {
    background-color: #375bb5 !important;
  }
  
  .bg-custom {
    background-color: #d3dff7;
  }
  
  </style>