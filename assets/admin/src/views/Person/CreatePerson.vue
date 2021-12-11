<template>
  <b-container>
    <person-form></person-form>
  </b-container>
</template>
<script>
import PersonForm from "../../components/Person/PersonForm.vue";
export default {
  name: "CreatePerson",
  components: {
    PersonForm,
  },
  mounted() {
    this.$store.dispatch("person/getPersonLabels");
  },
};
</script>