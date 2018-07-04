<template>
  <ol class="breadcrumb animated fadeIn">
    <li class="breadcrumb-item animated fadeIn">
      <router-link :to="{ name: 'HomePage' }">Home</router-link>
    </li>
    <li class="breadcrumb-item animated fadeIn" v-if="$route.meta.pretitle">
      {{ $route.meta.pretitle }}
    </li>
    <li class="breadcrumb-item animated fadeIn" v-if="$route.meta.title">
      {{ $route.meta.title }}
    </li>
  </ol>
</template>

<script>
  export default {
    name: 'breadcrumb'
  }
</script>