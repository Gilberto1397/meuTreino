import {createRouter, createWebHistory} from 'vue-router'
import LoginView from '@/components/login/LoginView.vue'
import Home from "@/components/home/Home.vue";
import ExerciseForm from "@/components/exercises/ExerciseForm.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'login',
            component: LoginView,
            meta: {
                exibirMenu: false,
                itemDeMenu: false,
                nomeItemMenu: 'Login'
            }
        },
        {
            path: '/home',
            name: 'home',
            component: Home,
            meta: {
                exibirMenu: true,
                itemDeMenu: true,
                nomeItemMenu: 'Home'
            }
        },
        {
            path: '/novo-exercicio',
            name: 'novoExercicio',
            component: ExerciseForm,
            meta: {
                exibirMenu: true,
                itemDeMenu: true,
                nomeItemMenu: 'Novo Exercício'
            }
        },
        {
            path: '/exercicio/:id',
            name: 'editarExercicio',
            component: ExerciseForm,
            meta: {
                exibirMenu: true,
                itemDeMenu: false,
                nomeItemMenu: 'Editar Exercício'
            }
        }
    ],
})

export default router
