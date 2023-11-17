<template>
  <div class="row">
    <div class="col-lg-12 m-auto">
      <div class="card custom-card">
        <div class="card-header">
          <h5 class="card-title fw-bold h4">REGISTRO CHECK IN</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <form>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">FECHA :</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text">
                  </div>

                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">VUELO N°:</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">NOMBRE :</label>
                  <div class="col-md-10">
                    <input class="form-control" type="text">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">C.I. :</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text">
                  </div>

                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">PUERTA:</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">ORIGEN :</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text">
                  </div>

                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">DESTINO:</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">HORA :</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text">
                  </div>

                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">ASIENTO:</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">PESO APROX :</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text">
                  </div>

                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">CANT. DE EQUIPAJE:</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">BAG TICKET N° :</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text">
                  </div>

                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">TOTAL KG:</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text">
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="col-md-2 col-form-label text-md-end fw-bold bg-secondary text-white f-size">EDAD :</label>
                  <div class="col-md-6">
                    <input class="form-control" type="text">
                  </div>
                </div>
              </form>
            </div>
            <div class="col-md-6">
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
      busqueda: '',
      users: [],
      loading: false,
      selectedUser: null,
    }
  },

  components: {
    Loading
  },

  methods: {
    buscarPaciente() {
      if (this.busqueda.length === 0) {
        this.resultados = []
        return
      }

      this.selectedUser = null
      this.loading = true

      axios
        .get(`/api/services/search?ci=${this.busqueda}`)
        .then((response) => {
          this.users = response.data.data
        })
        .catch((error) => {
          console.error('Error en la búsqueda:', error)
        })
        .finally(() => {
          this.loading = false
        })
    },

    showServices(user) {
      this.selectedUser = this.selectedUser === user ? null : user
    },
    
    getBenefits(services) {
      return services.reduce((benefits, service) => {
        return benefits.concat(service.benefits)
      }, []);
    },

    clearData() {
      this.busqueda = ''
      this.users = []
      this.selectedUser = null
    }
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
    font-size: 13px;
  }
</style>
