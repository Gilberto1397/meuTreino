import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

// Importar Bootstrap CSS e JS
// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
