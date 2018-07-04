<template>
  <div>
    <div v-if="products.length">
      <ul class="list-unstyled">
        <product-item v-for="(product, index) in products" :product="product" :key="index" />
      </ul>
      <mugen-scroll :handler="loadMore" :should-handle="loading" :threshold="-1" v-if="products.length >= 10">
        <div class="loader" v-if="loading">
          <half-circle-spinner
                  :animation-duration="1300"
                  :size="30"
                  color="#4285f4"
          />
        </div>
      </mugen-scroll>
    </div>
    <div v-else>
      <div class="col-md-12 text-center my-4">
        <h2>This category is empty.</h2>
        <router-link
                :to="{ name: 'CategoriesIndex' }"
                class="btn btn-secondary btn-md waves-effect waves-light"
        >
          Go back
        </router-link>
        <router-link
                :to="{ name: 'HomePage' }"
                class="btn btn-primary btn-md waves-effect waves-light"
        >
          Home Page
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
  import {HalfCircleSpinner} from 'epic-spinners'
  import MugenScroll from 'vue-mugen-scroll'
  import ProductItem from '../../components/ProductItem'
  import CategoryService from '../../services/Categories'

  export default {
    components: {
      HalfCircleSpinner,
      MugenScroll,
      ProductItem
    },
    data: () => ({
      loading: true,
      page: 1,
      products: []
    }),
    mounted () {
      this.fetchAll()
    },
    methods: {
      fetchAll () {
        CategoryService.fetchProducts(this.$route.params.slug, this.page)
          .then(response => response.data.data)
          .then(response => {
            this.products = response.products.data
          })
      },
      loadMore () {
        this.page++
        CategoryService.fetchProducts(this.$route.params.slug, this.page)
          .then(response => response.data)
          .then(response => {
            if (response.success) {
              let products = response.data.products.data
              setTimeout(() => {
                for (var i in products) {
                  this.products.push(products[i])
                }
              }, 1500)
            } else {
              this.page--
            }
          })
      }
    }
  }
</script>
