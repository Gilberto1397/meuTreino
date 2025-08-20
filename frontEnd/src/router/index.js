import {createRouter, createWebHistory} from 'vue-router'
import LoginView from '@/components/login/LoginView.vue'
import Home from "@/components/home/Home.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'login',
            component: LoginView,
        },
        {
            path: '/home',
            name: 'home',
            component: Home,
        }
    ],
})

export default router
