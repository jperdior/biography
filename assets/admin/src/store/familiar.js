import FamiliarApi from '../api/familiar.js';

const CREATING_CHILD = 'CREATING_CHILD',
    CREATING_CHILD_SUCCESS = 'CREATING_CHILD_SUCCESS',
    CREATING_CHILD_ERROR = 'CREATING_CHILD_ERROR',
    DELETING_CHILD = 'DELETING_CHILD',
    DELETING_CHILD_SUCCESS = 'DELETING_CHILD_SUCCESS',
    DELETING_CHILD_ERROR = 'DELETING_CHILD_ERROR';

export default {
    namespaced: true,
    state: {
        loading: false,
        error: null
    },
    getters: {
        loading: state => state.loading,
        error: state => state.error
    },
    mutations: {
        [CREATING_CHILD](state) {
            state.loading = true;
            state.error = null;
        },
        [CREATING_CHILD_SUCCESS](state) {
            state.loading = false;
        },
        [CREATING_CHILD_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [DELETING_CHILD](state) {
            state.loading = true;
            state.error = null;
        },
        [DELETING_CHILD_SUCCESS](state) {
            state.loading = false;
        },
        [DELETING_CHILD_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        }
    },
    actions: {
        async createChild({ commit }, personId) {
            commit(CREATING_CHILD);
            try {
                await FamiliarApi.createChild(personId);
                commit(CREATING_CHILD_SUCCESS);
            } catch (error) {
                commit(CREATING_CHILD_ERROR, error);
            }
        },
        async deleteChild({ commit }, childId) {
            commit(DELETING_CHILD);
            try {
                await FamiliarApi.deleteChild(childId);
                commit(DELETING_CHILD_SUCCESS);
            } catch (error) {
                commit(DELETING_CHILD_ERROR, error);
            }
        }
    }
}