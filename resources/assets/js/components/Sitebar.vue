<template>
  <div>
    <h4 class="font-weight-bold my-0 py-0">Categories</h4>
    <hr>
    <template v-if="categories.length">
      <ul class="list-group" v-for="category in categories">
        <router-link
              :to="{ name: 'CategoriesItem', params: { slug: category.slug }}"
              :class="'list-group-item d-flex justify-content-between align-items-center mb-1 ' + (category.slug == $route.params.slug ? 'active': '') "
        >
          {{ category.name }}
        </router-link>
      </ul>
    </template>
    <template v-else>
      <div class="text-center">
        No categories
      </div>
    </template>
  </div>
</template>

<script>
  import CategoryService from '../services/Categories'
  import { HollowDotsSpinner } from 'epic-spinners'
  import { mapGetters } from 'vuex'

  export default {
    name: 'sitebar',
    components: {
      HollowDotsSpinner
    },
    computed: mapGetters({
      categories: 'getCategories'
    })
  }
</script>