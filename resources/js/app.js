import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import vSelect from 'vue-select'
import '~/plugins'
import '~/components'
import BootstrapVue from 'bootstrap-vue'
import VeeValidate from 'vee-validate'
import VueValidationEs  from 'vee-validate/dist/locale/es'

Vue.use(BootstrapVue)

Vue.use(VeeValidate, {
  inject: 'false',
  fieldsBagName: 'veeFields',
  locale: 'es',
  dictionary: {
    es: VueValidationEs
  },
});

Vue.prototype.$setErrorsFromResponse = function(errorResponse) {
  if(!this.hasOwnProperty('$validator')) {
    return;
  }
    
  function addErrorToChildComponents(vm,field,errorString) {
    if(vm && vm.$validator && vm.$validator.errors){
      const inputfield = vm.$validator.fields.find({ name: field });
      if(inputfield){
      vm.$validator.errors.add({
        field,
        msg:errorString
      });
        return;
      }
    }
    if(vm.$children){
      vm.$children.map(async ($cvm) => {
        addErrorToChildComponents($cvm,field,errorString);
      });
    }
    return;
  }

  this.$validator.errors.clear();

  if(!errorResponse.hasOwnProperty('errors')) {
    return;
  }

  let errorFields = Object.keys(errorResponse.errors);

  errorFields.map(field => {
    let errorString = errorResponse.errors[field].join(', ');
    addErrorToChildComponents(this,field,errorString);     
  });
};

Vue.config.productionTip = false
Vue.component('v-select', vSelect);
new Vue({
  i18n,
  store,
  router,
  ...App
})
