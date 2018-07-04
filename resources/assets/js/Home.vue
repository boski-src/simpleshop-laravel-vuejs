<template>
  <div>
    <navbar/>
    <breadcrumb/>
    <div class="container">
      <div class="row justify-content-center mt-5">
        <div class="col-sm-3">
          <sitebar class="animated slideInUp"/>
        </div>
        <div class="col-sm-9">
          <h4 class="title" v-if="$route.meta.title">{{ $route.meta.title }}</h4>
          <h4 class="title" v-else-if="$route.meta.pretitle">{{ $route.meta.pretitle }}</h4>
          <hr>
          <!--<div class="text-center" >-->
            <!--<div class="loader">-->
              <!--<half-circle-spinner-->
                      <!--:animation-duration="1300"-->
                      <!--:size="30"-->
                      <!--color="#4285f4"-->
              <!--/>-->
            <!--</div>-->
          <!--</div>-->
          <router-view class="animated fadeIn" :key="$route.fullPath" />
        </div>
      </div>
    </div>
    <add-product v-if="logged && userPrivilege > 0"/>
    <add-category v-if="logged && userPrivilege > 0"/>
  </div>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex'
  import Navbar from './components/Navbar'
  import Breadcrumb from './components/Breadcrumb'
  import Sitebar from './components/Sitebar'
  import AddProduct from './components/modals/AddProduct'
  import AddCategory from './components/modals/AddCategory'

  export default {
    components: {
      Navbar,
      Breadcrumb,
      Sitebar,
      AddProduct,
      AddCategory,
    },
    computed: mapGetters({
      logged: 'getLogged',
      user: 'getUser',
      userPrivilege: 'getUserPrivilege',
    }),
    methods: mapActions([
      'getCategories',
      'getUser'
    ]),
    beforeMount () {
      this.getCategories()
      if (this.logged) {
        this.getUser()
      }
    }
  }
</script>

<style>
</style>