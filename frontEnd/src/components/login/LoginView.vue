<script setup>
import { ref, onMounted } from 'vue'
import axios from "axios";
import { useRouter, useRoute } from 'vue-router';

const routeBrowser = useRouter();
const routeDetails = useRoute();

const loginForm = ref({
  email: '',
  password: ''
})

const errors = ref({})
const loading = ref(false)

const validateForm = () => { //todo utilizar gup para validação
  errors.value = {}

  if (!loginForm.value.email) {
    errors.value.email = 'Email é obrigatório'
  } else if (!/\S+@\S+\.\S+/.test(loginForm.value.email)) {
    errors.value.email = 'Email deve ter um formato válido'
  }

  if (!loginForm.value.password) {
    errors.value.password = 'Senha é obrigatória'
  } else if (loginForm.value.password.length < 6) {
    errors.value.password = 'Senha deve ter pelo menos 6 caracteres'
  }

  return Object.keys(errors.value).length === 0
}

const handleLogin = async () => {
  try {
    if (validateForm()) {
      loading.value = true
      const dados = {
        email: loginForm.value.email,
        password: loginForm.value.password
      }

      const resposta = (await axios.post('http://127.0.0.1:8000/api/v1/autenticacao/login', dados)).data;
      localStorage.setItem('meuTreinoLoginToken', resposta.access_token);
      routeBrowser.push('/home');
    }
  } catch (error) {
    alert('DEU ERRO AO LOGAR');
  }
}

const isNotLogged = () => {
  if (Boolean(routeDetails.query.naologado)) {
    setTimeout(() => {
      alert('Ooops. Parece que você ainda não está logado!'); //todo usar sweetalert
    }, 1000)
  }
}

onMounted(() => {
  isNotLogged();
});
</script>

<template>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <h1>Bem-vindo</h1>
        <p>Faça login em sua conta</p>
      </div>

      <form @submit.prevent="handleLogin" class="login-form">
        <div class="form-group">
          <label for="email" class="form-label">Email</label>
          <input
            id="email"
            type="email"
            v-model="loginForm.email"
            class="form-input"
            :class="{ 'error': errors.email }"
            placeholder="Digite seu email"
            autocomplete="email"
          />
          <span v-if="errors.email" class="error-message">{{ errors.email }}</span>
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Senha</label>
          <input
            id="password"
            type="password"
            v-model="loginForm.password"
            class="form-input"
            :class="{ 'error': errors.password }"
            placeholder="Digite sua senha"
            autocomplete="current-password"
          />
          <span v-if="errors.password" class="error-message">{{ errors.password }}</span>
        </div>

        <div class="form-options">
          <label class="checkbox-label">
            <input type="checkbox" class="checkbox">
            <span class="checkbox-text">Lembrar-me</span>
          </label>
          <a href="#" class="forgot-password">Esqueceu a senha?</a>
        </div>

        <button
          type="submit"
          class="login-button"
          :disabled="loading"
        >
          <span v-if="loading" class="loading-spinner"></span>
          {{ loading ? 'Entrando...' : 'Entrar' }}
        </button>
      </form>

      <div class="login-footer">
        <p>Não tem uma conta? <a href="#" class="register-link">Cadastre-se</a></p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.login-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 1rem;
}

.login-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  padding: 2rem;
  width: 100%;
  max-width: 400px;
}

.login-header {
  text-align: center;
  margin-bottom: 2rem;
}

.login-header h1 {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 0.5rem;
}

.login-header p {
  color: #6b7280;
  font-size: 0.875rem;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-label {
  font-weight: 500;
  color: #374151;
  font-size: 0.875rem;
}

.form-input {
  padding: 0.75rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.2s ease;
  outline: none;
}

.form-input:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-input.error {
  border-color: #ef4444;
  box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.error-message {
  color: #ef4444;
  font-size: 0.75rem;
  margin-top: 0.25rem;
}

.form-options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 0.5rem 0;
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
}

.checkbox {
  width: 1rem;
  height: 1rem;
  accent-color: #667eea;
}

.checkbox-text {
  font-size: 0.875rem;
  color: #374151;
}

.forgot-password {
  color: #667eea;
  text-decoration: none;
  font-size: 0.875rem;
  transition: color 0.2s ease;
}

.forgot-password:hover {
  color: #5a6acf;
}

.login-button {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 8px;
  padding: 0.875rem 1rem;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  min-height: 48px;
}

.login-button:hover:not(:disabled) {
  transform: translateY(-1px);
  box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.25);
}

.login-button:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.loading-spinner {
  width: 1rem;
  height: 1rem;
  border: 2px solid transparent;
  border-top: 2px solid white;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.login-footer {
  text-align: center;
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid #e5e7eb;
}

.login-footer p {
  color: #6b7280;
  font-size: 0.875rem;
}

.register-link {
  color: #667eea;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s ease;
}

.register-link:hover {
  color: #5a6acf;
}

/* Responsividade */
@media (max-width: 480px) {
  .login-container {
    padding: 0.5rem;
  }

  .login-card {
    padding: 1.5rem;
  }

  .login-header h1 {
    font-size: 1.75rem;
  }

  .form-options {
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
  }
}
</style>