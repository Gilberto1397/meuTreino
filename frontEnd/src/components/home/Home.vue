<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";

const exercicesList = ref([]);

const getExercises = async () => {
  const response = (await axios.get('http://127.0.0.1:8000/api/v1/meus-exercicios')).data;
  exercicesList.value = response.data;
}

onMounted(async () => {
  await getExercises();
})
</script>

<template>
  <section class="d-flex flex-wrap flex-column gap-3 align-items-center flex-md-row justify-content-md-center">
    <div class="card" v-for="exercise in exercicesList" style="width: 18rem;"> <!-- todo ajustar essa largura -->
      <div class="card-body">
        <h5 class="card-title">{{exercise.name}}</h5>
        <h6 class="card-subtitle mb-2 text-body-secondary">SÉRIES - {{exercise.series}}</h6>
        <h6 class="card-subtitle mb-2 text-body-secondary">REPETIÇÕES - {{exercise.firstRepetitions}}</h6>
        <h6 class="card-subtitle mb-2 text-body-secondary">PESO - {{exercise.firstWeight}}</h6>
        <h6 class="card-subtitle mb-2 text-body-secondary">DESCANSO - {{exercise.firstRest}}</h6>
        <router-link :to="{name: 'editarExercicio', params: { id: exercise.id }}" href="#" class="card-link">+Mais informações</router-link>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>