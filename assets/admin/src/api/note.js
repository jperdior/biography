import axios from "axios";

export default {
    getNotes: function (personId) {
        return axios.get("/api/notes/" + personId);
    },
    getAdminNotes: function () {
        return axios.get("/api/admin_notes");
    },
    postNote: function (params) {
        return axios.post("/api/notes/" + params.personId, params.note);
    },
    deleteNote: function (noteId) {
        return axios.delete("/api/notes/" + noteId);
    },
    approveNote: function (noteId) {
        return axios.put("/api/notes/" + noteId + "/approve");
    },
    disapproveNote: function (noteId) {
        return axios.put("/api/notes/" + noteId + "/disapprove");
    }
}