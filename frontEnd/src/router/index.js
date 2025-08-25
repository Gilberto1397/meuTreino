import {createRouter, createWebHistory} from 'vue-router'
import LoginView from '@/components/login/LoginView.vue'
import Home from "@/components/home/Home.vue";
import CreateExercise from "@/components/exercises/CreateExercise.vue";

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
            component: CreateExercise,
            meta: {
                exibirMenu: true,
                itemDeMenu: true,
                nomeItemMenu: 'Novo Exercício'
            }
        }
    ],
})

export default router
