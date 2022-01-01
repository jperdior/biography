<template>
  <b-row>
    <b-col>
      <b-row>
        <b-col
          class="gallery-image"
          style="cursor: pointer"
          @click="removeImage"
        >
          <b-img
            v-if="!uploadedPicture"
            fluid
            :src="person.mainPictureBase64"
          ></b-img>
          <b-img v-if="uploadedPicture" fluid :src="uploadedPicture"></b-img>
        </b-col>
      </b-row>
      <br />
      <b-row>
        <b-col>
          <b-form id="main-picture-form">
            <b-form-group
              @change="uploadPicture"
              :label="labels.upload_picture"
            >
              <b-form-file
                ref="mainPicture"
                v-model="mainPicture"
              ></b-form-file>
            </b-form-group>
          </b-form>
        </b-col>
      </b-row>
    </b-col>
  </b-row>
</template>
<script>
import PersonApi from "../../api/person.js";
export default {
  name: "MainPersonPicture",
  props: {
    mainPerson: {
      type: Object,
      required: false,
      default: null,
    },
    person: {
      type: Object,
      required: false,
      default: null,
    },
  },
  computed: {
    labels() {
      return this.$store.getters["person/personLabels"];
    },
  },
  data() {
    return {
      mainPicture: null,
      uploadedPicture: null,
    };
  },
  watch: {
    mainPicture() {
      if (this.mainPicture) {
        this.uploadPicture();
      }
    },
  },
  methods: {
    imageUrl(file) {
      return URL.createObjectURL(file);
    },
    removeImage() {
      this.mainPicture = null;
    },
    async uploadPicture() {
      if (this.$props.person.mainPicture) {
        if (!confirm("Are you sure you want to replace the main picture?")) {
          this.$data.mainPicture = null;
          this.$refs.mainPicture.value = null;
          return false;
        }
      }
      let formData = new FormData();
      formData.append("mainPicture", this.mainPicture);
      const response = await PersonApi.uploadPersonMainPicture(
        this.$props.person.id,
        formData
      );
      if (response.status == 200) {
        this.$data.uploadedPicture = response.data;
        this.$data.mainPicture = null;
      }
    },
  },
};
</script>