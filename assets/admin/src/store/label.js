import LabelApi from '../api/label';

const GETTING_PERSON_LABELS = 'GETTING_PERSON_LABELS',
    GETTING_PERSON_LABELS_SUCCESS = 'GETTING_PERSON_LABELS_SUCCESS',
    GETTING_PERSON_LABELS_ERROR = 'GETTING_PERSON_LABELS_ERROR',
    GETTING_PRODUCT_LABELS = 'GETTING_PRODUCT_LABELS',
    GETTING_PRODUCT_LABELS_SUCCESS = 'GETTING_PRODUCT_LABELS_SUCCESS',
    GETTING_PRODUCT_LABELS_ERROR = 'GETTING_PRODUCT_LABELS_ERROR',
    GETTING_DEFAULT_LABELS = 'GETTING_DEFAULT_LABELS',
    GETTING_DEFAULT_LABELS_SUCCESS = 'GETTING_DEFAULT_LABELS_SUCCESS',
    GETTING_DEFAULT_LABELS_ERROR = 'GETTING_DEFAULT_LABELS_ERROR',
    GETTING_NOTE_LABELS = 'GETTING_NOTE_LABELS',
    GETTING_NOTE_LABELS_SUCCESS = 'GETTING_NOTE_LABELS_SUCCESS',
    GETTING_NOTE_LABELS_ERROR = 'GETTING_NOTE_LABELS_ERROR';

export default {
    namespaced: true,
    state: {
        loading: false,
        error: null,
        personLabels: [],
        productLabels: [],
        defaultLabels: [],
        noteLabels: []
    },
    getters: {
        loading: state => state.loading,
        error: state => state.error,
        personLabels: state => state.personLabels,
        productLabels: state => state.productLabels,
        defaultLabels: state => state.defaultLabels,
        noteLabels: state => state.noteLabels
    },
    mutations: {
        [GETTING_PERSON_LABELS](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_PERSON_LABELS_SUCCESS](state, personLabels) {
            state.loading = false;
            state.personLabels = personLabels.data;
        },
        [GETTING_PERSON_LABELS_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [GETTING_PRODUCT_LABELS](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_PRODUCT_LABELS_SUCCESS](state, productLabels) {
            state.loading = false;
            state.productLabels = productLabels.data;
        },
        [GETTING_PRODUCT_LABELS_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [GETTING_DEFAULT_LABELS](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_DEFAULT_LABELS_SUCCESS](state, defaultLabels) {
            state.loading = false;
            state.defaultLabels = defaultLabels.data;
        },
        [GETTING_DEFAULT_LABELS_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [GETTING_NOTE_LABELS](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_NOTE_LABELS_SUCCESS](state, noteLabels) {
            state.loading = false;
            state.noteLabels = noteLabels.data;
        },
        [GETTING_NOTE_LABELS_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        }
    },
    actions: {
        async getPersonLabels({ commit }) {
            commit(GETTING_PERSON_LABELS);
            try {
                const personLabels = await LabelApi.getPersonLabels();
                commit(GETTING_PERSON_LABELS_SUCCESS, personLabels);
            } catch (error) {
                commit(GETTING_PERSON_LABELS_ERROR, error);
            }
        },
        async getProductLabels({ commit }) {
            commit(GETTING_PRODUCT_LABELS);
            try {
                const productLabels = await LabelApi.getProductLabels();
                commit(GETTING_PRODUCT_LABELS_SUCCESS, productLabels);
            } catch (error) {
                commit(GETTING_PRODUCT_LABELS_ERROR, error);
            }
        },
        async getDefaultLabels({ commit }) {
            commit(GETTING_DEFAULT_LABELS);
            try {
                const defaultLabels = await LabelApi.getDefaultLabels();
                commit(GETTING_DEFAULT_LABELS_SUCCESS, defaultLabels);
            } catch (error) {
                commit(GETTING_DEFAULT_LABELS_ERROR, error);
            }
        },
        async getNoteLabels({ commit }) {
            commit(GETTING_NOTE_LABELS);
            try {
                const noteLabels = await LabelApi.getNoteLabels();
                commit(GETTING_NOTE_LABELS_SUCCESS, noteLabels);
            } catch (error) {
                commit(GETTING_NOTE_LABELS_ERROR, error);
            }
        }
    }
};