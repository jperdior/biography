<template>
  <b-form @submit.prevent="submitFamily">
    <b-input v-model="familyData.name" required></b-input>
    <b-button type="submit" variant="primary">Submit</b-button>
  </b-form>
</template>
<script>
export default {
  name: "FamilyForm",
  data() {
    return {
      familyData: {
        name: "",
      },
    };
  },
  methods: {
    submitFamily() {
      this.$store.dispatch("family/createFamily", this.$data.familyData);
      this.$data.familyData = {
        name: "",
      };
    },
  },
};
</script>