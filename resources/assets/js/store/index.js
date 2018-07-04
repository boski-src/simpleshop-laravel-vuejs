import Vue from 'vue'
import Vuex from 'vuex'

import global from './modules/global'
import user from './modules/user'
import basket from './modules/basket'

Vue.use(Vuex)

export default new Vuex.Store({
  strict: process.env.Node_ENV !== 'production',
  modules: {
    global,
    user,
    basket
  }
})