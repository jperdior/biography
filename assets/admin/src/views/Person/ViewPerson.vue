<template>
  <b-container></b-container>
</template>
<script>
import PersonApi from "../../api/person.js";
export default {
  name: "ViewPerson",
  async created() {
    const response = await PersonApi.getPersonNeedsLogin(this.$route.params.id);
    if (response.data.needsLogin) {
      this.$router.push("/private-person/" + this.$route.params.id);
    } else {
      this.$router.push("/person/" + this.$route.params.id);
    }
  },
};
</script>