import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import vSelect from 'vue-select'
import '~/plugins'
import '~/components'
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)
Vue.config.productionTip = false
Vue.component('v-select', vSelect);
new Vue({
  i18n,
  store,
  router,
  ...App
})
