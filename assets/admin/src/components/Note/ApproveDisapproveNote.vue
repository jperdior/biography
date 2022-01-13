<template>
  <span>
    <b-button @click="approveNote" v-if="!note.approved" variant="success">{{
      noteLabels.approve
    }}</b-button>
    <b-button @click="disapproveNote" v-else variant="warning">{{
      noteLabels.disapprove
    }}</b-button>
  </span>
</template>
<script>
export default {
  name: "ApproveDisapproveNote",
  props: {
    note: {
      type: Object,
      required: true,
    },
  },
  methods: {
    async approveNote() {
      const response = await this.$store.dispatch(
        "note/approveNote",
        this.note.id
      );
      if (response.status == 200) {
        this.$emit("statusChanged");
      }
    },
    async disapproveNote() {
      const response = await this.$store.dispatch(
        "note/disapproveNote",
        this.note.id
      );
      if (response.status == 200) {
        this.$emit("statusChanged");
      }
    },
  },
  computed: {
    noteLabels() {
      return this.$store.getters["label/noteLabels"];
    },
    defaultLabels() {
      return this.$store.getters["label/defaultLabels"];
    },
  },
};
</script>