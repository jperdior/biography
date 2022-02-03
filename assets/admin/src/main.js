import Vue from 'vue';
import App from './App.vue';
import BootstrapVue from "bootstrap-vue";
import router from './router';
import store from './store';
import VueQRCodeComponent from 'vue-qrcode-component';
import Toasted from 'vue-toasted';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faUserSecret } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import VueEllipseProgress from 'vue-ellipse-progress';

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

Vue.config.productionTip = false;

library.add(faUserSecret);

Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('qr-code', VueQRCodeComponent);

Vue.use(BootstrapVue);
Vue.use(Toasted);
Vue.use(VueEllipseProgress);

new Vue({
  store,
  router,
  render: h => h(App),
}).$mount('#app');
