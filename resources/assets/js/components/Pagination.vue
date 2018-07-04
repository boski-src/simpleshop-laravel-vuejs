<template>
  <ul class="pagination justify-content-center">
    <template v-if="paginator.current_page > 1">
      <li class="page-item">
        <router-link
                class="page-link"
                :to="{ name: $route.name, query: { page: 1 }}"
                aria-label="First"
        >
          <span aria-hidden="true">&laquo;</span>
        </router-link>
      </li>
      <li class="page-item">
        <router-link
                class="page-link"
                :to="{ name: $route.name, query: { page: (paginator.current_page - 1) }}"
                aria-label="First"
        >
          <span aria-hidden="true">&lsaquo;</span>
        </router-link>
      </li>
    </template>

    <li
            class="page-item"
            v-for="i in pages"
            :class="(paginator.current_page === i ? 'active' : '')"
    >
      <router-link
              class="page-link"
              :to="{ name: $route.name, query: { page: i }}"
              :aria-label="'Go to page: ' + i"
      >
        {{ i }}
      </router-link>
    </li>

    <template v-if="paginator.current_page < paginator.last_page">
      <li class="page-item">
        <router-link
                class="page-link"
                :to="{ name: $route.name, query: { page: paginator.current_page + 1 }}"
                aria-label="First"
        >
          <span aria-hidden="true">&rsaquo;</span>
        </router-link>
      </li>
      <li class="page-item">
        <router-link
                class="page-link"
                :to="{ name: $route.name, query: { page: paginator.last_page }}"
                aria-label="First"
        >
          <span aria-hidden="true">&raquo;</span>
        </router-link>
      </li>
    </template>
  </ul>
</template>

<script>
  export default {
    name: 'pagination',
    props: {
      paginator: {
        type: Object,
        required: true
      }
    },
    data: () => ({
      pages: []
    }),
    created () {
      let start = this.paginator.current_page - 6
      if (start < 1) start = 1
      let end = this.paginator.current_page + 6
      if (end > this.paginator.last_page) end = this.paginator.last_page
      for (var i = start; i <= end; i++) {
        this.pages.push(i);
      }
    }
  }
</script>

<style scoped>

</style>