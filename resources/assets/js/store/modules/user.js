import Vue from 'vue'
import router from '../../router'
import UserService from '../../services/Users'

let notify = new Vue()

const state = {
  logged: localStorage.getItem('user_token'),
  user: { privilege: 0 }
}

const getters = {
  getLogged: state => state.logged,
  getUser: state => state.user,
  getUserPrivilege: state => state.user.privilege
}

const actions = {
  login ({ commit }, credentials) {
    UserService.Login(credentials)
      .then(response => response.data)
      .then(response => {
        if (response.success) {
          localStorage.setItem('user_token', response.data.access_token)
          commit('login', response.data.user)

          notify.$toast.success(response.data.user.email, 'Successfylly logged!',
            { close: true, toastOnce: true, position: 'topRight' });

          if (router.currentRoute.query.redirect) {
            return router.push({path: router.currentRoute.query.redirect})
          }
          router.push({name: 'HomePage'})
        } else {
          notify.$toast.error('Credentials are invalid.', '',
            { close: true, toastOnce: true, position: 'topRight' });
        }
      })
  },
  create ({ commit }, credentials) {
    UserService.Create(credentials)
      .then(response => response.data)
      .then(response => {
        if (response.success) {
          router.push({ name: 'Login', query: { redirect: router.currentRoute.query.redirect } })
        } else {
          notify.$toast.error('Credentials are invalid.', 'Error:',
            { close: true, toastOnce: true, position: 'topRight' });
        }
      })
  },
  logout ({ commit }) {
    UserService.Logout()
      .then(response => response.data)
      .then(response => {
        console.log(response)
        if (response) {
          commit('logout')
          localStorage.removeItem('user_token')
          router.push({
            name: 'Login',
            query: {
              redirect: router.fullPath,
            },
          })
        } else {
          notify.$toast.error('Error:', 'Try again, later.',
            { close: true, toastOnce: true, position: 'topRight' });
        }
      })
  },
  getUser ({ commit }) {
    UserService.Me()
      .then(response => response.data)
      .then(response => {
        if (response.success) {
          commit('user', response.data)
        } else {
          this.logout()
        }
      })
  }
}

const mutations = {
  login (state, data) {
    state.logged = 1
    state.user = data
  },
  user: (state, data) => {
    state.user = data
  },
  logout (state) {
    state.logged = 0
    state.user = { privilege: 0 }
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}