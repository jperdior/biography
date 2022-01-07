import SubscriptionApi from '../api/subscription.js';

const GETTING_SUBSCRIPTION = 'GETTING_SUBSCRIPTION',
    GETTING_SUBSCRIPTION_SUCCESS = 'GETTING_SUBSCRIPTION_SUCCESS',
    GETTING_SUBSCRIPTION_ERROR = 'GETTING_SUBSCRIPTION_ERROR';

export default {
    namespaced: true,
    state: {
        subscription: {},
        loading: false,
        error: null
    },
    getters: {
        subscription: state => state.subscription,
        loading: state => state.loading,
        error: state => state.error
    },
    mutations: {
        [GETTING_SUBSCRIPTION](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_SUBSCRIPTION_SUCCESS](state, subscription) {
            state.loading = false;
            state.subscription = subscription.data.subscription;
        },
        [GETTING_SUBSCRIPTION_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        }
    },
    actions: {
        async getSubscription({ commit }) {
            commit(GETTING_SUBSCRIPTION);
            try {
                const subscription = await SubscriptionApi.getSubscription();
                commit(GETTING_SUBSCRIPTION_SUCCESS, subscription);
            } catch (error) {
                commit(GETTING_SUBSCRIPTION_ERROR, error);
            }
        }
    }
};