import NoteApi from '../api/note';

const CREATING_NOTE = 'CREATING_NOTE',
    CREATING_NOTE_SUCCESS = 'CREATING_NOTE_SUCCESS',
    CREATING_NOTE_ERROR = 'CREATING_NOTE_ERROR',
    GETTING_NOTES = 'GETTING_NOTES',
    GETTING_NOTES_SUCCESS = 'GETTING_NOTES_SUCCESS',
    GETTING_NOTES_ERROR = 'GETTING_NOTES_ERROR',
    GETTING_ADMIN_NOTES = 'GETTING_ADMIN_NOTES',
    GETTING_ADMIN_NOTES_SUCCESS = 'GETTING_ADMIN_NOTES_SUCCESS',
    GETTING_ADMIN_NOTES_ERROR = 'GETTING_ADMIN_NOTES_ERROR',
    DELETING_NOTE = 'DELETING_NOTE',
    DELETING_NOTE_SUCCESS = 'DELETING_NOTE_SUCCESS',
    DELETING_NOTE_ERROR = 'DELETING_NOTE_ERROR',
    APPROVING_NOTE = 'APPROVING_NOTE',
    APPROVING_NOTE_SUCCESS = 'APPROVING_NOTE_SUCCESS',
    APPROVING_NOTE_ERROR = 'APPROVING_NOTE_ERROR',
    DISAPPROVING_NOTE = 'DISAPPROVING_NOTE',
    DISAPPROVING_NOTE_SUCCESS = 'DISAPPROVING_NOTE_SUCCESS',
    DISAPPROVING_NOTE_ERROR = 'DISAPPROVING_NOTE_ERROR';


export default {
    namespaced: true,
    state: {
        loading: false,
        error: null,
        notes: []
    },
    getters: {
        loading: state => state.loading,
        error: state => state.error,
        notes: state => state.notes
    },
    mutations: {
        [CREATING_NOTE](state) {
            state.loading = true;
            state.error = null;
        },
        [CREATING_NOTE_SUCCESS](state) {
            state.loading = false;
        },
        [CREATING_NOTE_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [GETTING_NOTES](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_NOTES_SUCCESS](state, notes) {
            state.loading = false;
            state.notes = notes.data;
        },
        [GETTING_NOTES_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [GETTING_ADMIN_NOTES](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_ADMIN_NOTES_SUCCESS](state, notes) {
            state.loading = false;
            state.notes = notes.data;
        },
        [GETTING_ADMIN_NOTES_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [DELETING_NOTE](state) {
            state.loading = true;
            state.error = null;
        },
        [DELETING_NOTE_SUCCESS](state) {
            state.loading = false;
        },
        [DELETING_NOTE_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [APPROVING_NOTE](state) {
            state.loading = true;
            state.error = null;
        },
        [APPROVING_NOTE_SUCCESS](state) {
            state.loading = false;
        },
        [APPROVING_NOTE_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [DISAPPROVING_NOTE](state) {
            state.loading = true;
            state.error = null;
        },
        [DISAPPROVING_NOTE_SUCCESS](state) {
            state.loading = false;
        },
        [DISAPPROVING_NOTE_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        }
    },
    actions: {
        async createNote({ commit }, params) {
            commit(CREATING_NOTE);
            try {
                await NoteApi.postNote(params);
                commit(CREATING_NOTE_SUCCESS);
            } catch (error) {
                commit(CREATING_NOTE_ERROR, error);
            }
        },
        async getNotes({ commit }, personId) {
            commit(GETTING_NOTES);
            try {
                const notes = await NoteApi.getNotes(personId);
                commit(GETTING_NOTES_SUCCESS, notes);
            } catch (error) {
                commit(GETTING_NOTES_ERROR, error);
            }
        },
        async getAdminNotes({ commit }) {
            commit(GETTING_ADMIN_NOTES);
            try {
                const notes = await NoteApi.getAdminNotes();
                commit(GETTING_ADMIN_NOTES_SUCCESS, notes);
            } catch (error) {
                commit(GETTING_ADMIN_NOTES_ERROR, error);
            }
        },
        async deleteNote({ commit }, noteId) {
            commit(DELETING_NOTE);
            try {
                const response = await NoteApi.deleteNote(noteId);
                commit(DELETING_NOTE_SUCCESS);
                return response;
            } catch (error) {
                commit(DELETING_NOTE_ERROR, error);
            }
        },
        async approveNote({ commit }, noteId) {
            commit(APPROVING_NOTE);
            try {
                const response = await NoteApi.approveNote(noteId);
                commit(APPROVING_NOTE_SUCCESS);
                return response;
            } catch (error) {
                commit(APPROVING_NOTE_ERROR, error);
            }
        },
        async disapproveNote({ commit }, noteId) {
            commit(DISAPPROVING_NOTE);
            try {
                const response = await NoteApi.disapproveNote(noteId);
                commit(DISAPPROVING_NOTE_SUCCESS);
                return response;
            } catch (error) {
                commit(DISAPPROVING_NOTE_ERROR, error);
            }
        }
    }
};