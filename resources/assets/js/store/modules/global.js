import CategoryService from '../../services/Categories'

const state = {
  categories: []
}

const getters = {
  getCategories: state => state.categories
}

const actions = {
  getCategories ({ commit }) {
    CategoryService.fetchAll()
      .then(response => response.data)
      .then(response => {
        if (!response.success) return false
        commit('categories', response.data)
      })
  }
}

const mutations = {
  categories: (state, data) => state.categories = data
}

export default {
  state,
  getters,
  actions,
  mutations
}