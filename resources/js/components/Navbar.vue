<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
        APP
        <!-- <img v-if="user" src="/img/medical.png" alt="Logo" width="30" height="30" /> -->
      </router-link>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbar" class="collapse navbar-collapse">
        <!-- <ul class="navbar-nav">
          <locale-dropdown />
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
        </ul> -->
        <ul v-if="user" class="navbar-nav mx-lg-auto">
          <li class="nav-item">
            <router-link :to="{ name: 'home' }" class="nav-link" exact exact-active-class="active">
              Registro
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'services' }" class="nav-link" exact exact-active-class="active">
              Manifiesto
            </router-link>
          </li>
          <li class="nav-item" v-if="user.type == 'admin'">
            <router-link :to="{ name: 'users' }" class="nav-link" exact exact-active-class="active">
              Usuarios
            </router-link>
          </li>
          <li class="nav-item" v-if="user.type == 'admin'">
            <router-link :to="{ name: 'flights' }" class="nav-link" exact exact-active-class="active">
              Vuelos
            </router-link>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto">
          <!-- Authenticated -->
          <li v-if="user" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark"
               href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            >
              <img :src="user.photo_url" class="rounded-circle profile-photo me-1">
              
              <span v-if="user.type == 'admin'">Administrador: {{ user.name }}</span>
              <span v-else>Operador: {{ user.name }}</span>
            </a>
            <div class="dropdown-menu">
              <!-- <router-link :to="{ name: 'settings.profile' }" class="dropdown-item ps-3">
                <fa icon="cog" fixed-width />
                {{ $t('settings') }}
              </router-link> -->

              <a href="#" class="dropdown-item ps-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width />
                {{ $t('logout') }}
              </a>
            </div>
          </li>
          <!-- Guest -->
          <template v-else>
            <li class="nav-item">
              <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                {{ $t('login') }}
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      await this.$store.dispatch('auth/logout')

      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}

.container {
  max-width: 1100px;
}

.navbar .navbar-nav .nav-link {
  color: #000;
  font-size: 1.1em;
  padding: 0.8em;
}
.navbar {
  border-bottom: 5px solid #08197c;
}

.navbar .navbar-nav .nav-link.active {
  background-color: #08197c;
  color: #fff;
}
@media screen and (min-width: 992px) {
  .navbar {
    padding: 0;
  }
}
@media screen and (max-width: 991px) {
  .navbar-nav {
    padding-top: 0.5em;
  }
}
</style>
