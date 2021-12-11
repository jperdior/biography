<template>
  <b-row>
    <b-col>
      <b-form-group :label="label" :label-for="label">
        <b-form-input
          v-model="formPerson.name"
          :placeholder="labels.name"
          required
        ></b-form-input>
        <b-form-input
          v-model="formPerson.lastnames"
          :placeholder="labels.lastnames"
          required
        ></b-form-input>
      </b-form-group>
    </b-col>
  </b-row>
</template>
<script>
export default {
  name: "PersonSimpleForm",
  props: {
    person: {
      type: Object,
      required: true,
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
    this.$data.formPerson = this.$props.person;
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