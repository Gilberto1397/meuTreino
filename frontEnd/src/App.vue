<script setup>
import Menu from "@/components/navbar/Menu.vue";
import router from '@/router/index.js';
import {useRoute} from "vue-router";

const routeDetails = useRoute();
</script>

<template>
  <Menu
      v-if="routeDetails.meta.exibirMenu"
      :routes="router.getRoutes()"
  />

  <main id="boxPrincipal" class="w-100 px-3">
    <router-view/>
  </main>
</template>

<style scoped>

</style>
