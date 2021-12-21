<template>
  <b-container fluid>
    <b-table :items="persons"> </b-table>
  </b-container>
</template>
<script>
export default {
  name: "PersonList",
  mounted() {
    this.$store.dispatch("person/getPersons");
  },
  computed: {
    persons() {
      return this.$store.getters["person/persons"];
    },
  },
};
</script>