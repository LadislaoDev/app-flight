<template>
  <div class="row">
    <loading :active.sync="loading" :is-full-page="true" color="#08197c"></loading>
    <b-modal
      v-model="showModalPassenger"
      :header-bg-variant="'secondary'"
      size="lg"
      no-close-on-backdrop
      hide-footer
    >
      <template v-slot:modal-header="{ close }">
        <h5 class="text-white">Registro Pasajero</h5>
        <b-button squared size="sm" variant="primary" @click="closeModalPassenger">X</b-button>
      </template>
      <form @submit.prevent="createPassenger" @keydown="form.onKeydown($event)">
        <div class="modal-body">
          <!-- Name -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end fw-bold">Nombre Completo :</label>
            <div class="col-md-8">
              <input v-model="form.names" :class="{ 'is-invalid': form.errors.has('names') }" class="form-control" type="text">
              <has-error :form="form" field="names" />
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end fw-bold">CI :</label>
            <div class="col-md-8">
              <input v-model="form.ci" :class="{ 'is-invalid': form.errors.has('ci') }" class="form-control" type="text">
              <has-error :form="form" field="ci" />
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-end">
          <button @click="closeModalPassenger" type="button" class="btn btn-secondary"><fa icon="times-circle" fixed-width /> Cancelar</button>
          <v-button @click="createPassenger" :loading="form.busy">
            <fa icon="check-circle" fixed-width /> {{ $t('register') }}
          </v-button>
        </div>
      </form>
    </b-modal>
    <div class="col-lg-12 m-auto">
      <div class="card custom-card">
        <div class="card-header">
          <h5 class="card-title fw-bold h4">REGISTRO CHECK IN</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-5">
              <form>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">FECHA :</label>
                  <div class="col-md-10">
                    <!-- <input v-model="service.date" class="form-control" type="date"> -->
                    <b-form-group label-for="date" :invalid-feedback="errors.first('date')" :state="!errors.has('date')">
                      <b-form-input
                        v-model="service.date"   
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
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">VUELO N°:</label>
                  <div class="col-md-10">
                    <!-- <input v-model="service.flight_number" class="form-control" type="text"> -->
                    <!-- <b-form-group label-for="flight_number" :invalid-feedback="errors.first('flight_number')" :state="!errors.has('flight_number')">
                      <b-form-input
                        v-model="service.flight_number"   
                        :state="errors.has('flight_number') ? false : null"
                        v-validate="'required|max:64'"
                        data-vv-name="flight_number"
                        data-vv-as="n° vuelo"
                        type="text"
                      ></b-form-input> -->
                    <b-form-group label-for="flight_id" :invalid-feedback="errors.first('flight_id')" :state="!errors.has('flight_id')">
                      <v-select
                        label="number"
                        :filterable="false"
                        :options="flights"
                        v-model="service.flight_id"
                        @search="onSearchFlight"
                        :state="errors.has('flight_id') ? false : null"
                        v-validate="'required'"
                        data-vv-name="flight_id"
                        data-vv-as="n° de vuelo"
                      >
                        <template slot="no-options">Buscar vuelo..</template>
                        <template slot="option" slot-scope="flight">
                          <div>
                            <strong>{{ flight.number }}</strong>
                          </div>
                        </template>
                        <template slot="selected-option" slot-scope="flight">
                          <div>
                            <strong>{{ flight.number }}</strong>
                          </div>
                        </template>
                      </v-select>
                    </b-form-group>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">NOMBRE :</label>
                  <div class="col-md-10">
                    <!-- <pre>{{ $data }}</pre> -->
                    <b-form-group label-for="passenger_id" :invalid-feedback="errors.first('passenger_id')" :state="!errors.has('passenger_id')">
                      <div class="mb-0">
                        <div class="d-table-cell w-100 me-2">
                          <v-select
                            label="names"
                            :filterable="false"
                            :options="passengers"
                            v-model="service.passenger_id"
                            @search="onSearchPassenger"
                            :state="errors.has('passenger_id') ? false : null"
                            v-validate="'required'"
                            data-vv-name="passenger_id"
                            data-vv-as="pasajero"
                          >
                            <template slot="no-options">Buscar pasajero (CI)..</template>
                            <template slot="option" slot-scope="passenger">
                              <div>
                                <strong>{{ passenger.names }}</strong>
                              </div>
                            </template>
                            <template slot="selected-option" slot-scope="passenger">
                              <div>
                                <strong>{{ passenger.names }}</strong>
                              </div>
                            </template>
                          </v-select>
                        </div>
                        <div class="d-table-cell align-middle ml-2">
                          <button @click="showModalPassenger = !showModalPassenger" type="button" class="btn btn-primary btn-sm btn-height ms-1">
                            <fa icon="user-plus" fixed-width />
                          </button>
                        </div>
                      </div>
                    </b-form-group>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">C.I. :</label>
                  <div class="col-md-4">
                    <!-- <input v-model="service.ci" class="form-control" type="text"> -->
                    <b-form-group label-for="ci" :invalid-feedback="errors.first('ci')" :state="!errors.has('ci')">
                      <b-form-input
                        v-model="service.ci"   
                        :state="errors.has('ci') ? false : null"
                        v-validate="'required|max:64'"
                        data-vv-name="ci"
                        data-vv-as="ci"
                        type="text"
                      ></b-form-input>
                    </b-form-group>
                  </div>

                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">PUERTA:</label>
                  <div class="col-md-4">
                    <!-- <input v-model="service.door" class="form-control" type="number" min="0"> -->
                    <b-form-group label-for="door" :invalid-feedback="errors.first('door')" :state="!errors.has('door')">
                      <b-form-input
                        v-model="service.door"   
                        :state="errors.has('door') ? false : null"
                        v-validate="'required'"
                        data-vv-name="door"
                        data-vv-as="puerta"
                        type="number"
                        min="0"
                      ></b-form-input>
                    </b-form-group>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">ORIGEN :</label>
                  <div class="col-md-4">
                    <b-form-group label-for="origin" :invalid-feedback="errors.first('origin')" :state="!errors.has('origin')">
                      <!-- <select 
                        v-model="service.origin" 
                        class="form-select"
                        :state="errors.has('origin') ? false : null"
                        v-validate="'required'"
                        data-vv-name="origin"
                        data-vv-as="origen"
                      >
                        <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                      </select> -->
                      <b-form-input
                        disabled
                        v-model="service.origin"   
                        :state="errors.has('origin') ? false : null"
                        v-validate="'required'"
                        data-vv-name="origin"
                        data-vv-as="origen"
                        type="text"
                      ></b-form-input>
                    </b-form-group>
                  </div>

                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">DESTINO:</label>
                  <div class="col-md-4">
                    <b-form-group label-for="destiny" :invalid-feedback="errors.first('destiny')" :state="!errors.has('destiny')">
                      <!-- <select 
                        v-model="service.destiny" 
                        class="form-select"
                        :state="errors.has('destiny') ? false : null"
                        v-validate="'required'"
                        data-vv-name="destiny"
                        data-vv-as="destino"
                      >
                        <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                      </select> -->
                      <b-form-input
                        disabled
                        v-model="service.destiny"   
                        :state="errors.has('destiny') ? false : null"
                        v-validate="'required'"
                        data-vv-name="destiny"
                        data-vv-as="destino"
                        type="text"
                      ></b-form-input>
                    </b-form-group>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">HORA :</label>
                  <div class="col-md-4">
                    <!-- <input v-model="service.hour" class="form-control" type="time"> -->
                    <b-form-group label-for="hour" :invalid-feedback="errors.first('hour')" :state="!errors.has('hour')">
                      <b-form-input
                        disabled
                        v-model="service.hour"   
                        :state="errors.has('hour') ? false : null"
                        v-validate="'required'"
                        data-vv-name="hour"
                        data-vv-as="hora"
                        type="time"
                      ></b-form-input>
                    </b-form-group>
                  </div>

                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">ASIENTO:</label>
                  <div class="col-md-4">
                    <!-- <input v-model="service.seat.number" :readonly="true" class="form-control" type="text"> -->
                    <b-form-group label-for="seat" :invalid-feedback="errors.first('seat')" :state="!errors.has('seat')">
                      <b-form-input
                        disabled
                        v-model="service.seat.number"   
                        :state="errors.has('seat') ? false : null"
                        v-validate="'required'"
                        data-vv-name="seat"
                        data-vv-as="asiento"
                        type="text"
                      ></b-form-input>
                    </b-form-group>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">PESO APROX :</label>
                  <div class="col-md-4">
                    <!-- <input v-model="service.weight" class="form-control" type="number" min="0"> -->
                    <b-form-group label-for="weight" :invalid-feedback="errors.first('weight')" :state="!errors.has('weight')">
                      <b-form-input
                        v-model="service.weight"   
                        :state="errors.has('weight') ? false : null"
                        v-validate="'required'"
                        data-vv-name="weight"
                        data-vv-as="peso aprox."
                        type="number"
                        min="0"
                      ></b-form-input>
                    </b-form-group>
                  </div>

                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">CANT. DE EQUIPAJE:</label>
                  <div class="col-md-4">
                    <!-- <input v-model="service.quantity" class="form-control" type="number" min="0"> -->
                    <b-form-group label-for="quantity" :invalid-feedback="errors.first('quantity')" :state="!errors.has('quantity')">
                      <b-form-input
                        v-model="service.quantity"   
                        :state="errors.has('quantity') ? false : null"
                        v-validate="'required'"
                        data-vv-name="quantity"
                        data-vv-as="cantidad"
                        type="number"
                        min="0"
                      ></b-form-input>
                    </b-form-group>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">BAG TICKET N° :</label>
                  <div class="col-md-4">
                    <!-- <input v-model="service.ticket" class="form-control" type="text"> -->
                    <b-form-group label-for="ticket" :invalid-feedback="errors.first('ticket')" :state="!errors.has('ticket')">
                      <b-form-input
                        v-model="service.ticket"   
                        :state="errors.has('ticket') ? false : null"
                        v-validate="'required'"
                        data-vv-name="ticket"
                        data-vv-as="ticket"
                        type="text"
                      ></b-form-input>
                    </b-form-group>
                  </div>

                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">TOTAL KG:</label>
                  <div class="col-md-4">
                    <!-- <input v-model="service.total" class="form-control" type="number" min="0"> -->
                    <b-form-group label-for="total" :invalid-feedback="errors.first('total')" :state="!errors.has('total')">
                      <b-form-input
                        v-model="service.total"   
                        :state="errors.has('total') ? false : null"
                        v-validate="'required'"
                        data-vv-name="total"
                        data-vv-as="total"
                        type="number"
                        min="0"
                      ></b-form-input>
                    </b-form-group>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">EDAD :</label>
                  <div class="col-md-6">
                    <b-form-group label-for="age_id" :invalid-feedback="errors.first('age_id')" :state="!errors.has('age_id')">
                      <select 
                        v-model="service.age_id" 
                        class="form-select"
                        :state="errors.has('age_id') ? false : null"
                        v-validate="'required'"
                        data-vv-name="age_id"
                        data-vv-as="edad"
                      >
                        <option v-for="age in ages" :key="age.id" :value="age.id">{{ age.description }}</option>
                      </select>
                    </b-form-group>
                  </div>
                </div>
                <div class="row gap-3">
                  <div class="col ps-5">
                    <button @click="cleanService" type="button" class="btn btn-danger">
                      <fa icon="trash" fixed-width /> LIMPIAR
                    </button>
                  </div>
                  <div class="col">
                    <button @click="createService" type="button" class="btn btn-primary">
                      <fa icon="check-circle" fixed-width /> REGISTRAR
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-md-7">
              <div class="container" v-if="models.length > 0">
                <div class="mb-3">
                  <label for="modelSelector" class="form-label">Selecciona un modelo:</label>
                  <select v-model="selectedModelId" id="modelSelector" class="form-select">
                    <option v-for="model in models" :key="model.id" :value="model.id">{{ model.name }}</option>
                  </select>
                </div>
                <div v-if="selectedModel" class="model-container">
                  <div v-for="rowIndex in selectedModel.row" :key="rowIndex" class="row-container">
                    <div v-for="colIndex in selectedModel.column" :key="colIndex" class="place">
                      <label
                        v-if="placeVisible(rowIndex, colIndex)"
                        :class="{ 'place-label': true, 'place-gray': isPlaceGray(rowIndex, colIndex), 'place-green': isPlaceGreen(rowIndex, colIndex) }"
                      >
                        {{ getPlaceNumber(rowIndex, colIndex) }}
                        <input
                          type="radio"
                          name="selectedPlace"
                          :disabled="isPlaceDisabled(rowIndex, colIndex)"
                          :checked="isPlaceGreen(rowIndex, colIndex)"
                          @change="handleRadioChange(rowIndex, colIndex)"
                        />
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
function debounce(func, wait) {
  let timeout;

  return function (...args) {
    const context = this;

    clearTimeout(timeout);

    timeout = setTimeout(() => {
      func.apply(context, args);
    }, wait);
  };
}

import axios from 'axios';
import Form from 'vform'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'

export default {
  middleware: 'auth',
  data() {
    return {
      loading: true,
      showModalPassenger: false,
      ages: [],
      cities: [],
      models: [],
      selectedModelId: null,
      service: {
        date: '',
        ci: null,
        door: '',
        seat: {},
        weight: null,
        quantity: null,
        ticket: '',
        total: null,
        age_id: null,
        passenger_id: null,
        flight_id: null,
      },
      form: new Form({
        names: '',
        ci: '',
      }),
      passengers: [],
      flights: []
    }
  },

  watch: {
    'service.passenger_id': function (newValue) {
      if (newValue) {
        this.service.ci = newValue.ci
      } else {
        this.service.ci = ''
      }
    },

    'service.flight_id': function (newValue) {
      if (newValue) {
        const origin = this.cities.find(item => item.id === newValue.origin_id)
        const destiny = this.cities.find(item => item.id === newValue.destiny_id)
        this.service.origin = origin.name
        this.service.destiny = destiny.name
        this.service.hour = newValue.hour
      }
    }
  },

  computed: {
    selectedModel() {
      return this.models.find(model => model.id === this.selectedModelId);
    },

    selectedModelPlaces() {
      return this.selectedModel ? this.selectedModel.places : [];
    },
  },

  components: {
    Loading
  },

  created() {
    Promise.all([this.getTypesPlaces(), this.listAges(), this.listCities()])
    .then(() =>{
      this.loading = false
    })
  },

  methods: {
    cleanService() {
      this.service = {
        date: '',
        names: '',
        ci: '',
        door: '',
        seat: {},
        weight: null,
        quantity: null,
        ticket: '',
        total: null,
        age_id: null,
        passenger_id: null,
        flight_id: null
      }
    },

    cleanFormPassanger() {
      this.form.names = ''
      this.form.ci = ''
    },

    closeModalPassenger() {
      this.showModalPassenger = false
    },

    async createPassenger() {
      try {
        const { data } = await this.form.post('/api/passengers')
        if (data.success) {
          this.service.passenger_id = data.data
          this.closeModalPassenger()
          this.cleanFormPassanger()
        }
      } catch (error) {
        console.log(error)
      }
    },

    async createService() {
      try {

        this.$validator.errors.clear()
        this.loading = true

        let data = {
          date: this.service.date,
          ci: this.service.ci,
          door: this.service.door,
          seat: this.service.seat ? this.service.seat.number : null,
          place_id: this.service.seat ? this.service.seat.id : null,
          weight: this.service.weight,
          quantity: this.service.quantity,
          ticket: this.service.ticket,
          total: this.service.total,
          age_id: this.service.age_id,
          passenger_id: this.service.passenger_id ? this.service.passenger_id.id : null,
          flight_id: this.service.flight_id ? this.service.flight_id.id : null
        }

        axios({
          method: 'post',
          url: '/api/services',
          data: data
        })
        .then((response) => {
          this.cleanService()
          this.generatePDF(response.data.data.id)
          this.$validator.reset()
        })
        .catch((error) => {
          if(error.response.status === 422) this.$setErrorsFromResponse(error.response.data)
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
      // this.errors = null
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
            this.getTypesPlaces()
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

    placeVisible(rowIndex, colIndex) {
      const order = this.calculateOrder(rowIndex, colIndex);
      return this.selectedModelPlaces.some(place => place.order === order);
    },

    isPlaceGray(rowIndex, colIndex) {
      const order = this.calculateOrder(rowIndex, colIndex);
      const place = this.selectedModelPlaces.find(place => place.order === order);
      return place ? place.state === 0 : false;
    },

    isPlaceGreen(rowIndex, colIndex) {
      const order = this.calculateOrder(rowIndex, colIndex);
      const place = this.selectedModelPlaces.find(place => place.order === order);
      return place ? place.state === 1 : false;
    },

    isPlaceDisabled(rowIndex, colIndex) {
      const order = this.calculateOrder(rowIndex, colIndex);
      const place = this.selectedModelPlaces.find(place => place.order === order);
      return place ? place.disabled === 1 : false;
    },

    calculateOrder(rowIndex, colIndex) {
      const totalColumns = this.selectedModel.column;
      const invertedRowIndex = this.selectedModel.row - rowIndex;
      return invertedRowIndex * totalColumns + colIndex;
    },

    getPlaceNumber(rowIndex, colIndex) {
      const order = this.calculateOrder(rowIndex, colIndex);
      const place = this.selectedModelPlaces.find(place => place.order === order);
      return place ? place.number : '';
    },

    handleRadioChange(rowIndex, colIndex) {
      const order = this.calculateOrder(rowIndex, colIndex);
      this.selectedPlaceOrder = order;

      const selectedPlace = this.selectedModelPlaces.find(place => place.order === order);
      this.service.seat = selectedPlace;

      const placeIndex = this.selectedModelPlaces.findIndex(place => place.order === order);
      if (placeIndex !== -1) {
        this.selectedModelPlaces.forEach(place => {
          if (place.order !== order && place.state === 1 && place.disabled !== 1) {
            place.state = 0;
          }
        });

        this.selectedModelPlaces[placeIndex].state = 1;
      }
    },

    onSearchPassenger(search, loading) {
      loading(true)
      this.SearchPassenger(loading, search, this)
    },

    SearchPassenger: debounce(async function (loading, search, vm) {
      axios
        .post('/api/passengers/search', {
          ci: search,
        })
        .then((response) => {
          vm.passengers = response.data.data
          loading(false)
        })
        .catch((error) => {
          vm.passengers = []
          loading(false)
        })
        .finally(() => {
          loading(false)
        })
    }, 350),

    onSearchFlight(search, loading) {
      loading(true)
      this.SearchFlight(loading, search, this)
    },

    SearchFlight: debounce(async function (loading, search, vm) {
      axios
        .post('/api/flights/search', {
          number: search,
        })
        .then((response) => {
          vm.flights = response.data.data
          loading(false)
        })
        .catch((error) => {
          vm.flights = []
          loading(false)
        })
        .finally(() => {
          loading(false)
        })
    }, 350),

    getTypesPlaces() {
      axios
        .get('/api/types')
        .then((response) => {
          this.models = response.data.data
        })
    },

    listAges() {
      axios
        .get('/api/list/ages')
        .then((response) => {
          this.ages = response.data.data
        })
    },

    listCities() {
      axios
        .get('/api/list/cities')
        .then((response) => {
          this.cities = response.data.data
        })
    },
  },

  metaInfo () {
    return { title: this.$t('home') }
  }
}
</script>

<style scoped>
  .custom-card {
    height: 100%;
  }

  .f-size {
    font-size: 12px;
  }

  .model-container {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .row-container {
    display: flex;
    gap: 8px;
  }

  .place {
    width: 50px;
    height: 50px;
    border: 1px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .place-label {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .place-gray {
    background-color: #ccc;
  }

  .place-green {
    background-color: #8bc34a;
  }

  input[type="radio"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    opacity: 0;
    z-index: 1;
  }

  .btn-height {
    height: 37px;
  }
  >>> .vs__dropdown-toggle {
    background: #f7f9fb;
    height: 37px;
  }

  >>> .invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 11px;
    color: #dc3545;
  }
</style>
