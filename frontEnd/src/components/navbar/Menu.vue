<script setup>
import {useRoute, useRouter} from "vue-router";
import {computed} from "vue";
import axiosProvider from "@/providers/AxiosProvider.js";

const routeDetails = useRoute();
const routeBrowser = useRouter();
const props = defineProps({
  routes: {
    type: Array,
    required: true
  }
});

const routeName = computed(() => {
  return routeDetails.name;
})

const logout = async () => {
  await axiosProvider.delete('autenticacao/logout');
  localStorage.removeItem('meuTreinoLoginToken');

  routeBrowser.push({
    name: 'login'
  });
}

</script>

<template>
  <nav class="navbar navbar-expand-lg bg-primary mb-5">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li v-for="route in routes" class="nav-item">
            <router-link
                :to="route.path"
                v-if="routeName !== route.name && route.meta.itemDeMenu"
                class="nav-link active"
                aria-current="page" href="#">{{ route.meta.nomeItemMenu }}
            </router-link>
          </li>
        </ul>
      </div>

      <div>
        <button v-on:click="logout()" type="button" class="btn btn-outline-light">Logout</button>
      </div>
    </div>
  </nav>
</template>

<style scoped>

</style>