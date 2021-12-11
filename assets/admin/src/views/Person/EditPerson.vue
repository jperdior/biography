<template>
  <b-container>
    <person-form :person="person"></person-form>
  </b-container>
</template>
<script>
import PersonForm from "../../components/Person/PersonForm.vue";
export default {
  name: "EditPerson",
  components: {
    PersonForm,
  },
  mounted() {
    this.$store.dispatch("person/getPerson", this.$route.params.id);
    this.$store.dispatch("person/getPersonLabels");
  },
  computed: {
    person() {
      return this.$store.getters["person/person"];
    },
  },
};
</script>
