import './bootstrap'

import Vue from 'vue'
import router from './router'
import store from './store'
import App from './App'

import VeeValidate from 'vee-validate';
import VueIziToast from 'vue-izitoast'
import 'izitoast/dist/css/iziToast.min.css';

Vue.use(VeeValidate);
Vue.use(VueIziToast);

new Vue({
  el: '#app',
  store,
  router,
  template: '<App/>',
  components: {
    App
  }
})