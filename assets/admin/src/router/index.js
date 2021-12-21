import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
let currentURL = (window.location.pathname !== '/' ? window.location.pathname : '');

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../views/Person/PersonList.vue')
    },
    {
        path: '/families/:id',
        name: 'Family',
        component: () => import('../views/Family/FamilyView.vue')
    },
    {
        path: '/persons/create',
        name: 'CreatePerson',
        component: () => import('../views/Person/CreatePerson.vue')
    },
    {
        path: '/persons/edit/:id/:step?',
        name: 'EditPerson',
        component: () => import('../views/Person/EditPerson.vue')
    }
];

const router = new VueRouter({
    base: currentURL,
    routes
});

export default router;