import Vue from 'vue'

const BASKET_NAME = 'basket'
let notify = new Vue()

const state = {
  values: JSON.parse(localStorage.getItem(BASKET_NAME))
}

const getters = {
  getProducts: state => (state.values ? state.values.products : []),
  getPrice: state => (state.values ? state.values.price.toFixed(2) : 0)
}

const actions = {
  addToBasket ({ commit }, product) {
    if (!product.id) return false

    if (!localStorage.getItem(BASKET_NAME)) {
      this.clearBasket()
    }

    let productIndex = state.values.products.find(item => item.id === product.id)
    if (productIndex) {
      if (productIndex.quantity >= product.available) {
        return notify.$toast.warning('Product availability is too low.', 'Warning!',
          { close: true, toastOnce: true, position: 'topRight' });
      }
      commit('incrementQuantity', product.id)
    } else {
      if (!product.available) {
        return notify.$toast.warning('Product availability is too low.', 'Warning!',
          { close: true, toastOnce: true, position: 'topRight' });
      }
      commit('addProduct', product)
      notify.$toast.success('New product has been added to your cart. :)', 'Success!',
        { close: true, toastOnce: true, position: 'topRight' });
    }

    localStorage.setItem(BASKET_NAME, JSON.stringify(state.values))
  },
  removeFromBasket ({ commit }, { product, soft }) {
    if (!product.id) return false

    if (!localStorage.getItem(BASKET_NAME)) {
      this.clearBasket()
    }

    let productIndex = state.values.products.find(item => item.id === product.id)
    if (!productIndex) return false

    if (productIndex.quantity === 1 || soft === true) {
      commit('removeProduct', productIndex.id)
    } else {
      commit('decrementQuantity', product.id)
    }

    localStorage.setItem(BASKET_NAME, JSON.stringify(state.values))
  },
  clearBasket ({ commit }) {
    localStorage.setItem(BASKET_NAME, JSON.stringify({ products: [], price: 0 }))
    commit('updateBasket')
  }
}

const mutations = {
  addProduct (state, product) {
    state.values.products.push({
      id: product.id,
      category_id: product.category_id,
      slug: product.slug,
      name: product.name,
      price: product.price,
      available: product.available,
      quantity: 1
    })
    state.values.price += product.price
  },
  removeProduct (state, id) {
    let index = state.values.products.findIndex(item => item.id === id)
    const productItem = state.values.products.find(item => item.id === id)
    state.values.price -= (productItem.price * productItem.quantity)
    state.values.products.splice(index, 1)
  },
  incrementQuantity (state, id) {
    const productItem = state.values.products.find(item => item.id === id)
    productItem.quantity++
    state.values.price += productItem.price
  },
  decrementQuantity (state, id) {
    const productItem = state.values.products.find(item => item.id === id)
    productItem.quantity--
    state.values.price -= productItem.price
  },
  updateBasket (state) {
    state.values = JSON.parse(localStorage.getItem(BASKET_NAME))
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}