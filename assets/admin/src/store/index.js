import Vue from 'vue';
import Vuex from 'vuex';

import FamilyModule from './family';
import PersonModule from './person';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        family: FamilyModule,
        person: PersonModule
    }
});