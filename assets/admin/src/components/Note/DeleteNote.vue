<template>
  <span>
    <b-button @click="showDeleteNote" variant="danger">
      {{ defaultLabels.delete }}
    </b-button>
    <b-modal ref="deleteNoteModal" hide-footer :title="defaultLabels.delete">
      <p>{{ noteLabels.delete_confirm }}</p>
      <b-button @click="deleteNote" variant="danger">
        {{ defaultLabels.delete }}
      </b-button>
    </b-modal>
  </span>
</template>
<script>
export default {
  name: "DeleteNote",
  props: {
    note: {
      type: Object,
      required: true,
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
  methods: {
    async deleteNote() {
      const response = await this.$store.dispatch(
        "note/deleteNote",
        this.note.id
      );
      if (response.status == 200) {
        this.$refs.deleteNoteModal.hide();
        this.$emit("deleted");
      }
    },
    showDeleteNote() {
      this.$refs.deleteNoteModal.show();
    },
  },
};
</script>