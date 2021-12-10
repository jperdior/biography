<template>
  <span>
    <b-button v-b-modal="'createFamilyModal'">Create family</b-button>
    <b-modal id="createFamilyModal" ref="createFamilyModal">
      <family-form></family-form>
    </b-modal>
  </span>
</template>
<script>
import FamilyForm from "./FamilyForm.vue";
export default {
  name: "CreateFamily",
  components: {
    FamilyForm,
  },
};
</script>