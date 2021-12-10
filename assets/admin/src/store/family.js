import FamilyApi from './../api/family.js';

const CREATING_FAMILY = 'CREATING_FAMILY',
    CREATING_FAMILY_SUCCESS = 'CREATING_FAMILY_SUCCESS',
    CREATING_FAMILY_ERROR = 'CREATING_FAMILY_ERROR',
    GETTING_FAMILIES = 'GETTING_FAMILIES',
    GETTING_FAMILIES_SUCCESS = 'GETTING_FAMILIES_SUCCESS',
    GETTING_FAMILIES_ERROR = 'GETTING_FAMILIES_ERROR',
    GETTING_FAMILY = 'GETTING_FAMILY',
    GETTING_FAMILY_SUCCESS = 'GETTING_FAMILY_SUCCESS',
    GETTING_FAMILY_ERROR = 'GETTING_FAMILY_ERROR',
    UPDATING_FAMILY = 'UPDATING_FAMILY',
    UPDATING_FAMILY_SUCCESS = 'UPDATING_FAMILY_SUCCESS',
    UPDATING_FAMILY_ERROR = 'UPDATING_FAMILY_ERROR';

export default {
    namespaced: true,
    state: {
        families: [],
        family: {},
        loading: false,
        error: null
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        hasError(state) {
            return state.error !== null;
        },
        error(state) {
            return state.error;
        },
        families(state) {
            return state.families;
        },
        family(state) {
            return state.family;
        }
    },
    mutations: {
        [CREATING_FAMILY](state) {
            state.loading = true;
            state.error = null;
        },
        [CREATING_FAMILY_SUCCESS](state, family) {
            state.loading = false;
            state.error = null;
            state.families.push(family);
        },
        [CREATING_FAMILY_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [GETTING_FAMILIES](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_FAMILIES_SUCCESS](state, data) {
            state.loading = false;
            state.error = null;
            console.log(data["hydra:member"]);
            state.families = data["hydra:member"];
        },
        [GETTING_FAMILIES_ERROR](state, error) {
            state.loading = false;
            state.error = error;
            state.families = [];
        },
        [GETTING_FAMILY](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_FAMILY_SUCCESS](state, family) {
            state.loading = false;
            state.error = null;
            state.family = family;
        },
        [GETTING_FAMILY_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [UPDATING_FAMILY](state) {
            state.loading = true;
            state.error = null;
        },
        [UPDATING_FAMILY_SUCCESS](state, family) {
            state.loading = false;
            state.error = null;
            state.family = family;
        },
        [UPDATING_FAMILY_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        }
    },
    actions: {
        async createFamily({ commit }, family) {
            commit(CREATING_FAMILY);
            try {
                const response = await FamilyApi.createFamily(family);
                commit(CREATING_FAMILY_SUCCESS, response.data);
                return response.data;
            } catch (error) {
                commit(CREATING_FAMILY_ERROR, error);
                return null;
            }
        },
        async getFamilies({ commit }) {
            commit(GETTING_FAMILIES);
            try {
                const response = await FamilyApi.getFamilies();
                commit(GETTING_FAMILIES_SUCCESS, response.data);
                return response.data;
            } catch (error) {
                commit(GETTING_FAMILIES_ERROR, error);
                return null;
            }
        },
        async getFamily({ commit }, id) {
            commit(GETTING_FAMILY);
            try {
                const response = await FamilyApi.getFamily(id);
                commit(GETTING_FAMILY_SUCCESS, response.data);
                return response.data;
            } catch (error) {
                commit(GETTING_FAMILY_ERROR, error);
                return null;
            }
        },
        async updateFamily({ commit }, family) {
            commit(UPDATING_FAMILY);
            try {
                const response = await FamilyApi.updateFamily(family);
                commit(UPDATING_FAMILY_SUCCESS, response.data);
                return response.data;
            } catch (error) {
                commit(UPDATING_FAMILY_ERROR, error);
                return null;
            }
        }
    }
};
