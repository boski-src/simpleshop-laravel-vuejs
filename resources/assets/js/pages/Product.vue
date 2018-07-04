<template>
  <div class="text-center">
    <h2 class="h1-responsive font-weight-bold text-center my-4">{{ product.name }}</h2>
    <div class="view overlay zoom">
      <img
              :src="'/cloud/products/' + product.id + '/540x300'"
              class="img-fluid m-auto"
      >
      <p class="grey-text text-center w-responsive mx-auto mt-4">{{ product.description }}</p>
      <button class="btn btn-primary mt-2" :disabled="product.available < 0" @click="addToBasket(product)">
        <i class="fa fa-shopping-cart"></i>
        <span class="font-weight-bold">{{ product.price }}$</span>
      </button>
      <button
              type="button"
              class="btn btn-sm btn-danger px-3"
              v-if="userPrivilege > 0"
              @click="deleteProduct(product.id)"
      >
        <i class="fa fa-remove" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import mixin from '../mixins/index'
  import ProductService from '../services/Products'

  export default {
    name: 'product',
    mixins: [mixin],
    computed: mapGetters({
      userPrivilege: 'getUserPrivilege'
    }),
    data: () => ({
      product: {}
    }),
    mounted () {
      this.fetch()
    },
    methods: {
      ...mapActions(['addToBasket']),
      fetch () {
        ProductService.fetch(this.$route.params.id)
          .then(response => response.data)
          .then(response => {
            if (response.success) {
              this.product = response.data
            } else {
              this.$router.push({ name: 'HomePage' })
            }
          })
      },
      deleteProduct (id) {
        ProductService.delete(id)
          .then(response => response.data)
          .then(response => {
            if (response.success) {
              this.toastAlert('success', 'Product successfully deleted.')
              let productIndex = this.products.findIndex(item => item.id === id)
              this.products.splice(productIndex, 1)
            }
          })
      }
    }
  }
</script>

<style scoped>

</style>