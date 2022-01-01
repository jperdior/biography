<template>
  <b-row>
    <b-col>
      <b-row>
        <b-col>
          <h3>{{ label }}</h3>
        </b-col>
      </b-row>
      <b-row>
        <b-col md="6">
          <familiar-main-picture
            :person="person"
            :familiar="familiar"
          ></familiar-main-picture>
        </b-col>
        <b-col>
          <b-form-group :label="labels.name">
            <b-form-input
              v-model="formPerson.name"
              :placeholder="labels.name"
              required
            ></b-form-input>
          </b-form-group>
          <b-form-group :label="labels.lastnames">
            <b-form-input
              v-model="formPerson.lastnames"
              :placeholder="labels.lastnames"
              required
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
    </b-col>
  </b-row>
</template>
<script>
import FamiliarMainPicture from "./FamiliarMainPicture.vue";
export default {
  name: "PersonSimpleForm",
  components: {
    FamiliarMainPicture,
  },
  props: {
    familiar: {
      type: Object,
      required: true,
    },
    person: {
      type: Object,
      required: false,
      default: null,
    },
    label: {
      type: String,
      default: "",
    },
  },
  computed: {
    labels() {
      return this.$store.getters["person/personLabels"];
    },
  },
  mounted() {
    this.$data.formPerson = this.$props.familiar;
  },
  data() {
    return {
      formPerson: {
        name: "",
        lastnames: "",
      },
    };
  },
  watch: {
    formPerson() {
      this.$emit("updatePerson", this.$data.formPerson);
    },
  },
};
</script>