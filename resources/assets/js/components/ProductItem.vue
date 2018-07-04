<template>
  <li class="media mb-2">
    <img
            :src="'/cloud/products/' + product.id + '/70x70'"
            alt="Image"
            class="d-flex mr-3"
    >
    <div class="media-body">
      <h5 class="mt-0 mb-1 font-weight-bold">
        <router-link :to="{ name: 'Product', params: { id: product.id, slug: product.slug } }">{{ product.name }}</router-link>
        <small>
          (In stock: <b v-if="product.available < 0">0</b><b v-else>{{ product.available }}</b>)
        </small>
      </h5>
      {{ (product.description).slice(0, 50) }}
    </div>
    <button class="btn btn-primary" :disabled="product.available < 0" @click="addToBasket(product)">
      <i class="fa fa-shopping-cart"></i>
      <span class="font-weight-bold">{{ product.price }}$</span>
    </button>
    <button
            type="button"
            class="btn btn-danger px-3"
            v-if="userPrivilege > 0"
            @click="deleteProduct(product.id)"
    >
      <i class="fa fa-remove" aria-hidden="true"></i>
    </button>
  </li>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import ProductService from '../services/Products'

  export default {
    name: 'ProductItem',
    props: {
      product: {
        type: Object,
        required: true
      }
    },
    computed: mapGetters({
      userPrivilege: 'getUserPrivilege'
    }),
    methods: {
      ...mapActions(['addToBasket']),
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