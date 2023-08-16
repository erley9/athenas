<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Navbar from './components/Navbar.vue';
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
</script>

<template>
  <div class=".container-fluid ">
    <header  class="navbar navbar-dark bg-dark">
      <Navbar/>
    </header>
    <RouterView />
  </div>
</template>

<style scoped>


</style>
