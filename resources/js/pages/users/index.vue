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
        <button :disabled="loadingDelete" @click="deleteUser" type="button" class="btn btn-primary">
          <b-spinner v-if="loadingDelete" small variant="light"></b-spinner>
          <fa v-else icon="check-circle" fixed-width />
          ELIMINAR
        </button>
      </div>
    </b-modal>
    <b-modal
      v-model="showModalUser"
      :header-bg-variant="'secondary'"
      size="lg"
      no-close-on-backdrop
      hide-footer
    >
      <template v-slot:modal-header="{ close }">
        <h5 class="text-white">
          <span v-if="user.id">Modificar Usuario</span>
          <span v-else>Registrar Usuario</span>
        </h5>
        <b-button squared size="sm" variant="primary" @click="closeModalUser">X</b-button>
      </template>
      <form @submit.prevent="registerUser">
        <div class="mb-3 row">
          <label class="col-md-3 col-form-label text-md-end fw-bold">{{ $t('name') }}:</label>
          <div class="col-md-7">
            <b-form-group label-for="name" :invalid-feedback="errors.first('name')" :state="!errors.has('name')">
              <b-form-input
                v-model="user.name"   
                :state="errors.has('name') ? false : null"
                v-validate="'required'"
                data-vv-name="name"
                data-vv-as="nombre usuario"
                type="text"
              ></b-form-input>
            </b-form-group>
          </div>
        </div>

        <div class="mb-3 row">
          <label class="col-md-3 col-form-label text-md-end fw-bold">{{ $t('email') }}:</label>
          <div class="col-md-7">
            <b-form-group label-for="email" :invalid-feedback="errors.first('email')" :state="!errors.has('email')">
              <b-form-input
                v-model="user.email"   
                :state="errors.has('email') ? false : null"
                v-validate="'required'"
                data-vv-name="email"
                data-vv-as="correo electrónico"
                type="email"
              ></b-form-input>
            </b-form-group>
          </div>
        </div>

        <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end fw-bold">Ciudad:</label>
            <div class="col-md-7">
              <b-form-group label-for="city_id" :invalid-feedback="errors.first('city_id')" :state="!errors.has('city_id')">
                <select 
                  v-model="user.city_id" 
                  class="form-select"
                  :state="errors.has('city_id') ? false : null"
                  v-validate="'required'"
                  data-vv-name="city_id"
                  data-vv-as="ciudad"
                >
                  <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                </select>
              </b-form-group>
            </div>
          </div>

        <div class="mb-3 row">
          <label class="col-md-3 col-form-label text-md-end fw-bold">Tipo de Usuario:</label>
          <div class="col-md-7">
            <b-form-group label-for="rol" :invalid-feedback="errors.first('rol')" :state="!errors.has('rol')">
              <select 
                v-model="user.rol" 
                class="form-select"
                :state="errors.has('rol') ? false : null"
                v-validate="'required'"
                data-vv-name="rol"
                data-vv-as="rol"
              >
                <option v-for="rol in roles" :key="rol.id" :value="rol.description">{{ rol.text }}</option>
              </select>
            </b-form-group>
          </div>
        </div>
        
        <div class="mb-3 row">
          <label class="col-md-3 col-form-label text-md-end fw-bold">{{ $t('password') }}:</label>
          <div class="col-md-7">
            <b-form-group label-for="password" :invalid-feedback="errors.first('password')" :state="!errors.has('password')">
              <b-form-input
                v-model="user.password"   
                :state="errors.has('password') ? false : null"
                v-validate="'required'"
                data-vv-name="password"
                data-vv-as="contraseña"
                type="password"
              ></b-form-input>
            </b-form-group>
          </div>
        </div>

        <div class="mb-3 row">
          <label class="col-md-3 col-form-label text-md-end fw-bold">{{ $t('confirm_password') }}:</label>
          <div class="col-md-7">
            <b-form-group label-for="password_confirmation" :invalid-feedback="errors.first('password_confirmation')" :state="!errors.has('password_confirmation')">
              <b-form-input
                v-model="user.password_confirmation"   
                :state="errors.has('password_confirmation') ? false : null"
                v-validate="'required'"
                data-vv-name="password_confirmation"
                data-vv-as="confirmación contraseña"
                type="password"
              ></b-form-input>
            </b-form-group>
          </div>
        </div>
        <hr>
        <div class="d-flex justify-content-end">
          <button @click="closeModalUser" type="button" class="btn btn-secondary me-2"><fa icon="times-circle" fixed-width /> Cancelar</button>
          <button :disabled="loadingForm" @click="registerUser" type="button" class="btn btn-primary">
            <b-spinner v-if="loadingForm" small variant="light"></b-spinner>
            <fa v-else icon="check-circle" fixed-width />
            <span v-if="user.id">MODIFICAR</span>
            <span v-else>REGISTRAR</span>  
          </button>
        </div>
      </form>
    </b-modal>
    <div class="container mt-4">
      <div class="card">
        <div class="card-header">
          <h2 class="fw-bold">LISTA DE USUARIOS</h2>
        </div>
        <div class="card-body">
          <div class="d-flex flex-sm-row flex-column bg-custom">
            <div class="mr-auto p-2">
              <b-button @click="openModalUser" size="sm" variant="primary" class="ml-2">
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
              <b-button @click="getUsers" title="Actualizar Tabla" size="sm" variant="dark" class="mr-2">
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
                    <h6>No tienes usuarios registrados</h6>
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
                <template v-slot:head(name)="data">
                  <span>{{ data.label.toUpperCase() }}</span>
                </template>
                <template v-slot:head(email)="data">
                  <span>{{ data.label.toUpperCase() }}</span>
                </template>
                <template v-slot:head(city)="data">
                  <span>{{ data.label.toUpperCase() }}</span>
                </template>
                <template v-slot:head(type)="data">
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
                <template v-slot:cell(name)="data">
                  <strong>{{ data.value }}</strong>
                </template>
                <template v-slot:cell(email)="data">
                  <strong>{{ data.value }}</strong>
                </template>
                <template v-slot:cell(city)="data">
                  <strong>{{ data.value }}</strong>
                </template>
                <template v-slot:cell(type)="data">
                  <span v-html="templateType(data.value)"></span>
                </template>
                <template v-slot:cell(created)="data">
                  <strong>{{ data.value }}</strong>
                </template>
                <template v-slot:cell(updated)="data">
                  <strong>{{ data.value }}</strong>
                </template>
                <template v-slot:cell(opciones)="row">
                  <b-button @click="editUser(row.item)" size="sm" class="mr-2" variant="dark">
                    <fa icon="edit" fixed-width />
                  </b-button>
                  <b-button @click="openModalDelete(row.item)" size="sm" class="mr-2" variant="warning">
                    <fa icon="ban" fixed-width />
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
      showModalUser: false,
      showModalDelete: false,
      loadingForm: false,
      loadingDelete: false,
      user: {
        id: null,
        name: '',
        email: '',
        rol: '',
        city_id: null,
        password: '',
        password_confirmation: ''
      },
      userId: null,
      roles: [
        {id: 1, description: 'admin', text: 'administrador'},
        {id: 2, description: 'user', text: 'operador'}
      ],
      records: [],
      isBusy: false,
      columns: [
        { key: 'id', label: 'Nº'},
        { key: 'name', label: 'Nombre'},
        { key: 'email', label: 'Correo'},
        { key: 'city', label: 'Ciudad'},
        { key: 'type', label: 'Rol'},
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
        this.getUsers()
      }
    },
    currentPage: {
      handler: function(value) {
        this.getUsers()
      }
    },
    perPage: {
      handler: function(value) {
        this.getUsers()
      }
    }
  },

  components: {
    Loading
  },

  created() {
    Promise.all([this.getUsers(), this.listCities()])
    .then(() =>{
      this.loading = false
    })
  },

  methods: {
    editUser(row) {
      this.user.id = row.id
      this.user.name = row.name
      this.user.email = row.email
      this.user.rol = row.type
      this.user.city_id = row.city_id
      this.openModalUser()
    },

    openModalUser() {
      this.showModalUser = true  
    },

    closeModalUser() {
      this.showModalUser = false
      this.cleanUser()
    },

    openModalDelete(row) {
      this.userId = row.id
      this.showModalDelete = true
    },

    closeModalDelete() {
      this.userId = null
      this.showModalDelete = false
    },

    cleanUser() {
      this.user = {
        id: null,
        name: '',
        email: '',
        rol: '',
        city_id: null,
        password: '',
        password_confirmation: ''
      }
    },

    async getUsers() {
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

    async registerUser() {
      this.$validator.errors.clear()
      this.loadingForm = true

      if (this.user.id) {
        axios({
          method: 'put',
          url: `/api/update/user/${this.user.id}`,
          data: this.user
        })
        .then((response) => {
          this.showModalUser = false
          this.cleanUser()
          this.getUsers()

          this.loadingForm = false
        })
        .catch((error) => {
          if(error.response.status === 422) this.$setErrorsFromResponse(error.response.data)
          this.loadingForm = false
        })
      } else {
        axios({
          method: 'post',
          url: '/api/register/user',
          data: this.user
        })
        .then((response) => {
          this.showModalUser = false
          this.cleanUser()
          this.getUsers()

          this.loadingForm = false
        })
        .catch((error) => {
          if(error.response.status === 422) this.$setErrorsFromResponse(error.response.data)
          this.loadingForm = false
        })
      }
    },

    listCities() {
      axios
        .get('/api/list/cities')
        .then((response) => {
          this.cities = response.data.data
        })
    },

    async deleteUser() {
      this.loadingDelete = true
      axios({
        method: 'delete',
        url: `/api/delete/user/${this.userId}`,
      })
      .then((response) => {
        if (response.data.success) {
          this.closeModalDelete()
          this.getUsers()
        }
        
        this.loadingDelete = false
      })
      .catch((error) => {
        this.loadingDelete = false
      })
    },

    buildURL() {
      let sort = `?sort=${this.sort}`
      let current_page = `&page=${this.currentPage}`
      let per_page = `&per_page=${this.perPage}`
      return `/api/users${sort}${current_page}${per_page}`
    },

    templateType(status) {
      switch (status) {
        case 'admin':
          return (
            "<span class='badge bg-primary'>Administrador</span>"
          );
          break;
        case 'user':
          return (
            "<span class='badge bg-info text-dark'>Operador</span>"
          );
          break;
        default:
          return (
            "<span class='badge bg-info text-dark'>Operador</span>"
          );
      }
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