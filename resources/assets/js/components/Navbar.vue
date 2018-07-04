<template>
  <nav class="navbar navbar-expand-lg navbar-dark primary-color scrolling-navbar">
    <div class="container">
      <router-link
            :to="{ name: 'HomePage' }"
            class="navbar-brand"
      >
        Shop App
      </router-link>
      <button
              class="navbar-toggler"
              type="button"
              data-toggle="collapse"
              data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <router-link
                    :to="{ name: 'HomePage' }"
                    class="nav-link waves-effect"
            >
              Home page
              <span class="sr-only">(current)</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                    :to="{ name: 'CategoriesIndex' }"
                    class="nav-link waves-effect"
            >
              Categories
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                    :to="{ name: 'ShoppingCart' }"
                    class="nav-link waves-effect"
            >
              <i class="fa fa-shopping-cart"></i>
              <span class="clearfix d-none d-sm-inline-block"> Cart </span>
              <span
                      class="badge red z-depth-1 ml-1"
                      v-if="basketProducts.length"
              >
                Items: {{ (basketProducts.length ? basketProducts.length : 0) }}
                Price: {{ (basketPrice ? basketPrice + '$' : 0) }}
              </span>
              <span class="badge red z-depth-1 ml-1" v-else>0</span>
            </router-link>
          </li>
        </ul>
        <form class="form-inline">
          <div class="md-form my-0">
            <input
                    class="form-control"
                    type="text"
                    placeholder="Search"
                    aria-label="Search"
                    v-model="keyword"
                    @keyup="search"
            >
            <div class="dropdown-wrapper position-absolute" style="z-index: 1000">
              <ul class="list-group" v-if="keyword.length >= 3">
                <template v-if="products.length">
                  <li class="list-group-item d-flex justify-content-between align-items-center" v-for="product in products">
                    <router-link :to="{ name: 'Product', params: { id: product.id, slug: product.slug } }" @click.native="reset">
                      {{ product.name }}
                    </router-link>
                    <span class="badge badge-primary badge-pill">{{ product.price }}$</span>
                  </li>
                </template>
                <template v-else>
                  <li class="list-group-item text-center">
                    No results for: <b>"{{ keyword }}"</b>
                  </li>
                </template>
              </ul>
            </div>
          </div>
        </form>
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a
                  class="nav-link dropdown-toggle waves-effect waves-light"
                  id="navbarDropdownMenuLink"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="true"
            >
              <i class="fa fa-user"></i> Account
            </a>
            <div
                    class="dropdown-menu"
                    aria-labelledby="navbarDropdownMenuLink"
            >
              <template v-if="logged">
                <a><small>{{ user.email }}</small></a>
                <hr class="py-0 my-2">
                <a
                        class="dropdown-item waves-effect waves-light"
                        data-toggle="modal"
                        data-target="#addProduct"
                        v-if="userPrivilege > 0"
                >
                  Add product
                </a>
                <a
                        class="dropdown-item waves-effect waves-light"
                        data-toggle="modal"
                        data-target="#addCategory"
                        v-if="userPrivilege > 0"
                >
                  Add category
                </a>
                <router-link
                        class="dropdown-item waves-effect waves-light"
                        :to="{name: 'AccountOrders'}"
                >
                  My orders
                </router-link>
                <a class="dropdown-item waves-effect waves-light" @click="logout">
                  Logout
                </a>
              </template>
              <template v-else>
                <router-link
                        class="dropdown-item waves-effect waves-light"
                        :to="{name: 'Login'}"
                >
                  Sign in
                </router-link>
                <router-link
                        class="dropdown-item waves-effect waves-light"
                        :to="{name: 'Register'}"
                >
                  Create Account
                </router-link>
              </template>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
  import { mapGetters } from 'vuex'
  import mixin from '../mixins/index'
  import ProductService from '../services/Products'
  import {HalfCircleSpinner} from 'epic-spinners'

  export default {
    name: 'navbar',
    components: {
      HalfCircleSpinner
    },
    mixins: [mixin],
    computed: mapGetters({
      basketPrice: 'getPrice',
      basketProducts: 'getProducts',
      logged: 'getLogged',
      user: 'getUser',
      userPrivilege: 'getUserPrivilege',
    }),
    data: () => ({
      keyword: '',
      products: []
    }),
    methods: {
      logout () {
        this.$store.dispatch('logout');
      },
      search () {
        if (this.keyword.length < 3) return false
        this.products = []
        ProductService.search(this.keyword)
          .then(response => response.data)
          .then(response => {
            if (response.success) {
              this.products = response.data
            }
          })
      },
      reset () {
        this.keyword = ''
        this.products = []
      },
    }
  }
</script>