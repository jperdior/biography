<template>
  <b-row>
    <b-col>
      <b-button @click="showRemoveGalleryModal" variant="danger">
        {{ labels.delete_gallery }}
      </b-button>
      <b-modal ref="removeGalleryModal" @ok="removeGallery()">
        {{ labels.delete_gallery_warning }}
      </b-modal>
    </b-col>
  </b-row>
</template>
<script>
import GalleryApi from "../../../api/gallery.js";
export default {
  name: "GalleryRemover",
  props: {
    gallery: {
      type: Object,
      required: false,
      default: null,
    },
  },
  computed: {
    labels() {
      return this.$store.getters["label/personLabels"];
    },
  },
  methods: {
    showRemoveGalleryModal() {
      this.$refs.removeGalleryModal.show();
    },
    async removeGallery() {
      const response = await GalleryApi.deleteGallery(this.$props.gallery.id);
      if (response.status === 204) {
        this.$emit("galleryRemoved");
        this.$toasted.success(this.labels.removed_successfully, {
          duration: 5000,
          theme: "bubble",
        });
      }
    },
  },
};
</script>