<script setup>
import {ref, computed, watch, onMounted} from 'vue'
import axiosProvider from "@/providers/AxiosProvider.js";
import {useRouter, useRoute} from 'vue-router';

const isUpdate = ref(false);
const isCreate = ref(false);

const exercise = ref({
  exerciseId: '',
  name: '',
  seriesCount: null,
  exerciseDetail: '',
  serie: []
});

const routeBrowser = useRouter();
const routeDetails = useRoute();

// Computed para garantir que o número de séries seja válido
const validSeriesCount = computed(() => {
  const count = parseInt(exercise.value.seriesCount)
  return isNaN(count) || count < 1 ? 0 : count
})

// Observa mudanças no número de séries e atualiza o array de dados
watch(validSeriesCount, (newCount) => {
  const currentLength = exercise.value.serie.length

  if (newCount > currentLength) {
    // Adiciona novas séries
    for (let i = currentLength; i < newCount; i++) {
      exercise.value.serie.push({
        repetitions: '',
        weight: '',
        rest: ''
      })
    }
  } else if (newCount < currentLength) {
    // Remove séries excedentes
    exercise.value.serie = exercise.value.serie.slice(0, newCount)
  }
})

const createOrUpdate = async () => {
  if (isCreate.value) {
    await saveExercise();
  } else if (isUpdate.value) {
    await updateExercise();
  }
}

const saveExercise = async () => { //TODO E SE NÃO INFORMAR VALORES PARA AS REPETIÇÕES, PESO E DESCANSO?
  try {
    const resposta = (await axiosProvider.post('meus-exercicios', exercise.value)).data;

    if (confirm('Exercício criado')) {
      isCreate.value = false;
      routeBrowser.push('/home'); //todo usar nome da rota
    }
  } catch (error) {
    alert('DEU ERRO AO CRIAR EXERCÍCIO');
  }
}

const updateExercise = async () => { //TODO E SE NÃO INFORMAR VALORES PARA AS REPETIÇÕES, PESO E DESCANSO?
  try {
    const resposta = (await axiosProvider.put('meus-exercicios', exercise.value)).data;

    if (confirm('Exercício atualizado!')) {
      isUpdate.value = false;
      await routeBrowser.push('/home'); //todo usar nome da rota
    }
  } catch (error) {
    alert('DEU ERRO AO CRIAR EXERCÍCIO');
  }
}

const getExercise = async (id) => {
  try {
    const resposta = (await axiosProvider.get(`meus-exercicios/${id}`)).data;
    exercise.value = resposta.data[0];
  } catch (error) {
    alert('DEU ERRO AO TRAZER EXERCÍCIO');
  }
}

const isShowExercise = async () => {
  const exerciseId = routeDetails.params?.id

  if (!exerciseId) {
    isCreate.value = true;
    isUpdate.value = true;
    return;
  }
  await getExercise(exerciseId);
  exercise.value.exerciseId = exerciseId;
}

const updateActive = () => {
  const switchElement = document.getElementById('switchUpdate');
  isUpdate.value = switchElement.checked;
}

onMounted(async () => {
  await isShowExercise();
})
</script>

<template>
  <section class="larguraTelaMedia">
    <div v-if="! isCreate" class="form-check form-switch d-flex justify-content-center column-gap-2">
      <input v-on:change="updateActive" class="form-check-input" type="checkbox" role="switch" id="switchUpdate">
      <label class="form-check-label" for="switchUpdate">Atualizar exercício?</label>
    </div>

    <form @submit.prevent="createOrUpdate()">
      <div class="mb-3">
        <label for="exerciseName" class="form-label">Nome do Exercício</label>
        <input
            :disabled="! isUpdate"
            type="text"
            class="form-control"
            id="exerciseName"
            v-model="exercise.name"
            placeholder="Digite o nome do exercício"
        >
      </div>

      <div class="mb-3">
        <label for="series" class="form-label">Séries</label>
        <input
            :disabled="! isUpdate"
            type="number"
            class="form-control"
            id="series"
            v-model="exercise.seriesCount"
            placeholder="Número de séries"
            min="1"
        >
      </div>

      <div class="mb-3">
        <label for="series" class="form-label">Observação</label>
        <textarea
            :disabled="! isUpdate"
            class="form-control"
            id="exerciseDetail"
            v-model="exercise.exerciseDetail"
            placeholder="Observação sobre o exercício"
        >
        </textarea>
      </div>

      <!-- Campos dinâmicos para cada série -->
      <div v-if="validSeriesCount > 0" class="mb-4">
        <h5 class="mb-3">Detalhes das Séries</h5>

        <div
            v-for="(serie, index) in exercise.serie"
            :key="index"
            class="card mb-3"
        >
          <div class="card-header">
            <h6 class="mb-0">Série {{ index + 1 }}</h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <label :for="`repetitions-${index}`" class="form-label">Repetições</label>
                <input
                    :disabled="! isUpdate"
                    type="number"
                    class="form-control"
                    :id="`repetitions-${index}`"
                    v-model="serie.repetitions"
                    placeholder="Nº de repetições"
                    min="1"
                >
              </div>
              <div class="col-md-4">
                <label :for="`weight-${index}`" class="form-label">Peso (kg)</label>
                <input
                    :disabled="! isUpdate"
                    type="number"
                    class="form-control"
                    :id="`weight-${index}`"
                    v-model="serie.weight"
                    placeholder="Peso em kg"
                    step="0.5"
                    min="0"
                >
              </div>
              <div class="col-md-4">
                <label :for="`rest-${index}`" class="form-label">Descanso (seg)</label>
                <input
                    :disabled="! isUpdate"
                    type="number"
                    class="form-control"
                    :id="`rest-${index}`"
                    v-model="serie.rest"
                    placeholder="Descanso em segundos"
                    min="0"
                >
              </div>

              <div class="mt-2">
                <label :for="`rest-${index}`" class="form-label">Detalhes da série</label>
                <textarea
                    :disabled="! isUpdate"
                    class="form-control"
                    :id="`detail-${index}`"
                    v-model="serie.detail"
                    placeholder="Descanso em segundos"
                >
                </textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <button v-if="isCreate" type="submit" class="btn btn-primary">Criar Exercício</button>
      <button v-else type="submit" :disabled="! isUpdate" class="btn btn-primary">Atualizar Exercício</button>
    </form>
  </section>
</template>

<style scoped>
.card {
  border: 1px solid #dee2e6;
}

.card-header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #dee2e6;
}

.form-label {
  font-weight: 500;
}

.larguraTelaMedia {
  width: 100%;
}

@media (min-width: 768px) {
  .larguraTelaMedia {
    width: 60%;
    margin: 0 auto;
  }
}
</style>