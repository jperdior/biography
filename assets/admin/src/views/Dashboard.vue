<template>
  <b-container>
    <b-row>
      <b-col>
        <b-img fluid src="/img/logo.png"></b-img>
        <h1>{{ labels.welcome }}</h1>
      </b-col>
    </b-row>

    <b-row v-if="!mainPerson">
      <b-col>
        <p>
          {{ labels.no_persons }}
        </p>
        <b-button variant="primary" :to="{ name: 'CreatePerson' }">{{
          labels.create_person
        }}</b-button>
      </b-col>
    </b-row>

    <b-row v-else>
      <b-button
        variant="success"
        :to="{ name: 'EditPerson', params: { id: mainPerson.id } }"
        >{{ labels.edit_person }}</b-button
      >
    </b-row>
  </b-container>
</template>
<script>
export default {
  name: "Dashboard",
  mounted() {
    this.$store.dispatch("person/getMainPerson");
  },
  computed: {
    mainPerson() {
      return this.$store.getters["person/mainPerson"];
    },
    labels() {
      return this.$store.getters["person/personLabels"];
    },
  },
};
</script>