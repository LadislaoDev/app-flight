<template>
  <div class="login-page bg-light">
    <div class="container">
      <div class="row mt-5">
        <div class="col-lg-8 offset-lg-2">
          <h2 class="mb-3 text-center fw-bold">{{ $t('login') }}</h2>
          <div class="bg-white shadow rounded">
            <div class="row">
              <div class="col-md-5 ps-0 d-none d-md-block">
                  <img src="/img/logo2.jpg" alt="Imagen" style="width: 100%; height: 100%; object-fit: cover;" />
              </div>

              <div class="col-md-7 pe-0">
                <div class="form-left h-100 py-5 ps-4 pe-5">
                  <form @submit.prevent="login" @keydown="form.onKeydown($event)" class="row g-4">
                    <div class="col-12">
                      <label>Usuario<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="input-group-text"><fa icon="user" fixed-width /></div>
                        <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
                        <has-error :form="form" field="name" />
                      </div>
                    </div>

                    <div class="col-12">
                      <label>{{ $t('password') }}<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="input-group-text"><fa icon="lock" fixed-width /></div>
                        <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
                        <has-error :form="form" field="password" />
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <checkbox v-model="remember" name="remember">
                        {{ $t('remember_me') }}
                      </checkbox>
                    </div>

                    <div class="col-sm-6">
                      <router-link :to="{ name: 'password.request' }" class="float-end">
                        {{ $t('forgot_password') }}
                      </router-link>
                    </div>

                    <vue-recaptcha
                      ref="recaptcha"
                      @verify="onCaptchaVerified"
                      sitekey="6LeMJD4pAAAAAOdN21qr3B2pnMfzGAdQ8wn3R4JN"
                    ></vue-recaptcha>

                    <div class="col-12">
                      <div class="d-grid gap-2">
                        <v-button :disabled="!captchaResponse" :loading="form.busy" :type="'secondary'">
                          INGRESAR
                        </v-button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <p class="text-end text-secondary mt-3 fw-bold">APP. V-1.0</p>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import Form from 'vform'
import Cookies from 'js-cookie'
import VueRecaptcha from 'vue-recaptcha'

export default {
  components: {
    VueRecaptcha,
  },

  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
      name: '',
      password: ''
    }),
    remember: false,
    captchaResponse: null,
  }),

  methods: {
    onCaptchaVerified(response) {
      this.captchaResponse = response;
    },

    async login () {
      if (this.captchaResponse) {
      const { data } = await this.form.post('/api/login')

      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      await this.$store.dispatch('auth/fetchUser')

      this.redirect()
      } else {
        alert('Por favor, completa el reCAPTCHA.');
      }
    },

    redirect () {
      const intendedUrl = Cookies.get('intended_url')

      if (intendedUrl) {
        Cookies.remove('intended_url')
        this.$router.push({ path: intendedUrl })
      } else {
        this.$router.push({ name: 'home' })
      }
    }
  }
}
</script>
<style scoped>
  .img-fluid {
    width: 100%; 
    height: 355px;
  }
</style>