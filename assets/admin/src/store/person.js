import PersonApi from './../api/person.js';

const CREATING_PERSON = 'CREATING_PERSON',
    CREATING_PERSON_SUCCESS = 'CREATING_PERSON_SUCCESS',
    CREATING_PERSON_ERROR = 'CREATING_PERSON_ERROR',
    GETTING_PERSON = 'GETTING_PERSON',
    GETTING_PERSON_SUCCESS = 'GETTING_PERSON_SUCCESS',
    GETTING_PERSON_ERROR = 'GETTING_PERSON_ERROR',
    UPDATING_PERSON = 'UPDATING_PERSON',
    UPDATING_PERSON_SUCCESS = 'UPDATING_PERSON_SUCCESS',
    UPDATING_PERSON_ERROR = 'UPDATING_PERSON_ERROR',
    GETTING_PERSON_LABELS = 'GETTING_PERSON_LABELS',
    GETTING_PERSON_LABELS_SUCCESS = 'GETTING_PERSON_LABELS_SUCCESS',
    GETTING_PERSON_LABELS_ERROR = 'GETTING_PERSON_LABELS_ERROR',
    GETTING_PERSONS = 'GETTING_PERSONS',
    GETTING_PERSONS_SUCCESS = 'GETTING_PERSONS_SUCCESS',
    GETTING_PERSONS_ERROR = 'GETTING_PERSONS_ERROR';

export default {
    namespaced: true,
    state: {
        persons: [],
        person: {},
        personLabels: null,
        loading: false,
        error: null
    },
    getters: {
        persons: state => state.persons,
        person: state => state.person,
        loading: state => state.loading,
        error: state => state.error,
        personLabels: state => state.personLabels
    },
    mutations: {
        [CREATING_PERSON](state) {
            state.loading = true;
            state.error = null;
        },
        [CREATING_PERSON_SUCCESS](state, person) {
            state.loading = false;
            state.person = person;
        },
        [CREATING_PERSON_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [GETTING_PERSON](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_PERSON_SUCCESS](state, person) {
            state.loading = false;
            state.person = person;
        },
        [GETTING_PERSON_ERROR](state, error) {
            state.loading = false;
            state.error = error;
            state.person = null;
        },
        [UPDATING_PERSON](state) {
            state.loading = true;
            state.error = null;
        },
        [UPDATING_PERSON_SUCCESS](state, person) {
            state.loading = false;
            state.person = person;
        },
        [UPDATING_PERSON_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [GETTING_PERSON_LABELS](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_PERSON_LABELS_SUCCESS](state, personLabels) {
            state.loading = false;
            state.personLabels = personLabels;
        },
        [GETTING_PERSON_LABELS_ERROR](state, error) {
            state.loading = false;
            state.error = error;
            state.personLabels = null;
        },
        [GETTING_PERSONS](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_PERSONS_SUCCESS](state, persons) {
            state.loading = false;
            state.persons = persons["hydra:member"];
        },
        [GETTING_PERSONS_ERROR](state, error) {
            state.loading = false;
            state.error = error;
            state.persons = [];
        }
    },
    actions: {
        async createPerson({ commit }, person) {
            commit(CREATING_PERSON);
            try {
                const response = await PersonApi.createPerson(person);
                commit(CREATING_PERSON_SUCCESS, response.data);
                return response;
            } catch (error) {
                commit(CREATING_PERSON_ERROR, error);
            }
        },
        async getPerson({ commit }, id) {
            commit(GETTING_PERSON);
            try {
                const response = await PersonApi.getPerson(id);
                commit(GETTING_PERSON_SUCCESS, response.data);
            } catch (error) {
                commit(GETTING_PERSON_ERROR, error);
            }
        },
        async updatePerson({ commit }, person) {
            commit(UPDATING_PERSON);
            try {
                const response = await PersonApi.updatePerson(person);
                commit(UPDATING_PERSON_SUCCESS, response.data);
                return response;
            } catch (error) {
                commit(UPDATING_PERSON_ERROR, error);
            }
        },
        async getPersonLabels({ commit }) {
            commit(GETTING_PERSON_LABELS);
            try {
                const response = await PersonApi.getLabels();
                commit(GETTING_PERSON_LABELS_SUCCESS, response.data);
            } catch (error) {
                commit(GETTING_PERSON_LABELS_ERROR, error);
            }
        },
        async getPersons({ commit }) {
            commit(GETTING_PERSONS);
            try {
                const response = await PersonApi.getPersons();
                commit(GETTING_PERSONS_SUCCESS, response.data);
            } catch (error) {
                commit(GETTING_PERSONS_ERROR, error);
            }
        }
    }
};