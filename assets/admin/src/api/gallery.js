import axios from "axios";

export default {

    createGallery: function (galleryData) {
        return axios.post('/api/galleries/' + galleryData.id, galleryData.gallery);
    },
    updateGallery: function (galleryData) {
        return axios.post(`/api/gallery/${galleryData.id}/update`, galleryData.gallery);
    },
    deleteGallery: function (galleryId) {
        return axios.delete(`/api/galleries/${galleryId}`);
    }

}