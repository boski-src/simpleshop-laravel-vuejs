<template>
  <div>
    <template v-if="products.length">
      <ul class="list-unstyled">
        <product-item v-for="(product, index) in products" :product="product" :key="index" />
      </ul>
    </template>
    <template v-else>
      <div class="col-md-12 text-center my-4">
        <h2>No products</h2>
      </div>
    </template>
  </div>
</template>

<script>
  import ProductService from '../services/Products'
  import ProductItem from '../components/ProductItem'

  export default {
    components: {
      ProductItem
    },
    data: () => ({
      products: []
    }),
    mounted () {
      this.fetchNewest()
    },
    methods: {
      fetchNewest () {
        ProductService.fetchNewest()
          .then(response => response.data)
          .then(response => {
            this.products = response.data
          })
      }
    }
  }
</script>
