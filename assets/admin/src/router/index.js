import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
let currentURL = (window.location.pathname !== '/' ? window.location.pathname : '');

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../views/Family/FamilyList.vue')
    }
];

const router = new VueRouter({
    base: currentURL,
    routes
});

export default router;