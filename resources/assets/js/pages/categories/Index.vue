<template>
  <div class="row">
    <template v-if="categories.length">
      <div class="col-md-4 mb-3" v-for="category in categories">
        <div class="card">
          <div class="view overlay">
            <img
                  class="card-img-top"
                  :src="'/cloud/categories/' + category.id + '/500x350'"
            >
            <router-link :to="{ name: 'CategoriesItem', params: { slug: category.slug } }">
              <div class="mask rgba-white-slight"></div>
            </router-link>
          </div>
          <div class="card-body text-center">
            <h5 class="card-title">{{ category.name }}</h5>
            <router-link
                    :to="{ name: 'CategoriesItem', params: { slug: category.slug } }"
                    class="btn btn-primary"
            >
              All products
            </router-link>
            <div>
              <button
                      type="button"
                      class="btn btn-sm btn-danger px-3"
                      v-if="userPrivilege > 0"
                      @click="deleteCategory(category.id)"
              >
                <i class="fa fa-remove" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>
    <template v-else>
      <div class="col-md-12 text-center my-4">
        <h2>No categories.</h2>
      </div>
    </template>
  </div>
</template>

<script>
  import mixin from '../../mixins/index'
  import { mapGetters, mapActions } from 'vuex'
  import CategoryService from '../../services/Categories'

  export default {
    mixins: [mixin],
    computed: mapGetters({
      categories: 'getCategories',
      userPrivilege: 'getUserPrivilege'
    }),
    methods: {
      ...mapActions(['getCategories']),
      deleteCategory (id) {
        CategoryService.delete(id)
          .then(response => response.data)
          .then(response => {
            if (response.success) {
              this.toastAlert('success', 'Category successfully deleted.')
              this.getCategories()
            }
          })
      }
    }
  }
</script>
