<script setup>
import {useRoute} from "vue-router";
import {computed} from "vue";

const routeDetails = useRoute();
const props = defineProps({
  routes: {
    type: Array,
    required: true
  }
});

const routeName = computed(() => {
  return routeDetails.name;
})

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
    </div>
  </nav>
</template>

<style scoped>

</style>