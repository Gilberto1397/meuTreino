<script setup>
import { ref, computed, watch } from 'vue'

const exerciseName = ref('')
const seriesCount = ref('')
const seriesData = ref([])

// Computed para garantir que o número de séries seja válido
const validSeriesCount = computed(() => {
  const count = parseInt(seriesCount.value)
  return isNaN(count) || count < 1 ? 0 : count
})

// Observa mudanças no número de séries e atualiza o array de dados
watch(validSeriesCount, (newCount) => {
  const currentLength = seriesData.value.length

  if (newCount > currentLength) {
    // Adiciona novas séries
    for (let i = currentLength; i < newCount; i++) {
      seriesData.value.push({
        repetitions: '',
        weight: '',
        rest: ''
      })
    }
  } else if (newCount < currentLength) {
    // Remove séries excedentes
    seriesData.value = seriesData.value.slice(0, newCount)
  }
})

const handleSubmit = (event) => {
  event.preventDefault()
  console.log('Exercício:', exerciseName.value)
  console.log('Número de séries:', validSeriesCount.value)
  console.log('Dados das séries:', seriesData.value)
}
</script>

<template>
<section class="larguraTelaMedia">
  <form @submit="handleSubmit">
    <div class="mb-3">
      <label for="exerciseName" class="form-label">Nome do Exercício</label>
      <input
        type="text"
        class="form-control"
        id="exerciseName"
        v-model="exerciseName"
        placeholder="Digite o nome do exercício"
      >
    </div>

    <div class="mb-3">
      <label for="series" class="form-label">Séries</label>
      <input
        type="number"
        class="form-control"
        id="series"
        v-model="seriesCount"
        placeholder="Número de séries"
        min="1"
      >
    </div>

    <!-- Campos dinâmicos para cada série -->
    <div v-if="validSeriesCount > 0" class="mb-4">
      <h5 class="mb-3">Detalhes das Séries</h5>

      <div
        v-for="(serie, index) in seriesData"
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
                type="number"
                class="form-control"
                :id="`rest-${index}`"
                v-model="serie.rest"
                placeholder="Descanso em segundos"
                min="0"
              >
            </div>
          </div>
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Criar Exercício</button>
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