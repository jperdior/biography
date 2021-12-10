import Vue from 'vue';
import Vuex from 'vuex';

import FamilyModule from './family';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        family: FamilyModule,
    }
});