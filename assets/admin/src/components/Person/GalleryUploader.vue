<template>
  <b-row>
    <b-col>
      <b-button @click="showGalleryUploader">{{ uploadButtonText }}</b-button>
      <b-modal ref="showGalleryUploader" size="lg" :hide-footer="true">
        <b-form>
          <b-form-group :label="labels.gallery_title">
            <b-form-input v-model="title" required></b-form-input>
          </b-form-group>
          <b-form-group :label="labels.gallery" label-for="gallery">
            <b-form-file multiple v-model="images"></b-form-file>
            <div id="preview">
              <b-row>
                <b-col
                  class="gallery-image"
                  v-for="(file, i) in images"
                  v-bind:key="i"
                  style="cursor: pointer"
                  @click="removeImage(i)"
                >
                  <b-img fluid :src="imageUrl(file)"></b-img>
                </b-col>
              </b-row>
            </div>
          </b-form-group>
          <b-button
            :disabled="!images.length"
            variant="success"
            @click="saveGallery()"
            >{{ labels.save_gallery }}</b-button
          >
        </b-form>
      </b-modal>
    </b-col>
  </b-row>
</template>
<script>
import GalleryApi from "../../api/gallery.js";
export default {
  name: "GalleryUploader",
  props: {
    person: {
      type: Object,
      required: false,
      default: null,
    },
    gallery: {
      type: Object,
      required: false,
      default: null,
    },
  },
  computed: {
    labels() {
      return this.$store.getters["person/personLabels"];
    },
    uploadButtonText() {
      if (this.$props.gallery.id) {
        return this.labels.add_pictures;
      }
      return this.labels.create_gallery;
    },
  },
  data() {
    return {
      images: [],
      title: "",
    };
  },
  methods: {
    showGalleryUploader() {
      this.$refs.showGalleryUploader.show();
    },
    imageUrl(file) {
      return URL.createObjectURL(file);
    },
    removeImage(imageIndex) {
      this.$data.images.splice(imageIndex, 1);
    },
    async saveGallery(galleryIndex) {
      let data = new FormData();
      if (!this.$data.images.length) {
        return false;
      }
      data.append("title", this.$data.title);
      for (var i = 0; i < this.$data.images.length; i++) {
        data.append(
          "images[" + i + "]",
          this.$data.images[i],
          this.$data.images[i].name
        );
      }

      if (this.$props.gallery.id) {
        data.append("gallery_id", this.$props.gallery.id);
        const response = await GalleryApi.updateGallery(data);
        if (response.status === 201) {
          this.$toasted.success(this.labels.saved_successfully, {
            duration: 5000,
            theme: "bubble",
          });
          this.$refs.showGalleryUploader.hide();
          this.$store.dispatch("person/getPerson", this.$props.person.id);
        }
        return;
      }
      if (this.$props.person) {
        data.append("person_id", this.$props.person.id);
        const response = await GalleryApi.createGallery(data);
        if (response.status === 201) {
          this.$toasted.success(this.labels.saved_successfully, {
            duration: 5000,
            theme: "bubble",
          });
          this.$refs.showGalleryUploader.hide();
          this.$store.dispatch("person/getPerson", this.$props.person.id);
        }
      }
    },
  },
};
</script>