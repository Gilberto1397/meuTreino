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
                public: true,
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
                public: false,
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
                public: false,
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
                public: false,
                exibirMenu: true,
                itemDeMenu: false,
                nomeItemMenu: 'Editar Exercício'
            }
        }
    ],
});

router.beforeEach((routeTo, routeFrom, next) => {
    //const authenticationStore = useAuthenticationStore();

    if (!routeTo.meta.public && !localStorage.getItem('meuTreinoLoginToken')) {
        next({
            name: 'login',
            query: {naologado: true}
        });
    }

    if (routeTo.path === '/login' && localStorage.getItem('meuTreinoLoginToken')) {
        next({name: 'home'});
    }
    next();
})


export default router
