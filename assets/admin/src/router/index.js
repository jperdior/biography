import Vue from 'vue';
import VueRouter from 'vue-router';
import store from "../store";
import Login from "../views/Login";
import Register from "../views/Register";

Vue.use(VueRouter);
let currentURL = (window.location.pathname !== '/' ? window.location.pathname : '');

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../views/Home.vue')
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        meta: { requiresAuth: true },
        component: () => import('../views/Dashboard.vue')
    },
    {
        path: '/view-person/:id',
        name: 'View Person',
        component: () => import('../views/Person/ViewPerson.vue')
    },
    {
        path: '/person/:id',
        name: 'Person',
        component: () => import('../views/Person/ViewPublicPerson.vue')
    },
    {
        path: '/private-person/:id',
        name: 'Private Person',
        meta: { requiresAuth: true },
        component: () => import('../views/Person/ViewPrivatePerson.vue')
    },
    {
        path: '/persons/create',
        name: 'CreatePerson',
        meta: { requiresAuth: true },
        component: () => import('../views/Person/CreatePerson.vue')
    },
    {
        path: '/persons/edit/:id/:step?',
        name: 'EditPerson',
        meta: { requiresAuth: true },
        component: () => import('../views/Person/EditPerson.vue')
    },
    {
        path: '/checkout',
        name: 'Checkout',
        meta: { requiresAuth: true },
        component: () => import('../views/Checkout/Checkout.vue')
    },
    { path: "/login", name: 'Login', component: Login },
    { path: "/register", name: 'Register', component: Register },
    { path: "/about", name: 'About', component: () => import('../views/About.vue') },
];

const router = new VueRouter({
    base: currentURL,
    routes
});



router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        console.log(store.getters["security/isAuthenticated"]);
        if (store.getters["security/isAuthenticated"]) {
            next();
        } else {
            next({
                path: "/login",
                query: { redirect: to.fullPath }
            });
        }
    } else {
        next(); // make sure to always call next()!
    }
});

export default router;