import Vue from 'vue';
import Vuex from 'vuex';

import SecurityModule from "./security";
import PersonModule from './person';
import FamiliarModule from './familiar';
import ProductModule from './product';
import SubscriptionModule from './subscription';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        person: PersonModule,
        security: SecurityModule,
        familiar: FamiliarModule,
        product: ProductModule,
        subscription: SubscriptionModule
    }
});