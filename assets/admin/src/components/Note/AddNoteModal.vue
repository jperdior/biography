<template>
  <span>
    <b-button variant="primary" @click="showModal">
      Añadir nota de pésame
    </b-button>
    <b-modal ref="addNoteModal" :title="'Add note'" :hide-footer="true">
      <note-form @noteCreated="noteCreatedEvent" :person="person"></note-form>
    </b-modal>
  </span>
</template>
<script>
import NoteForm from "./NoteForm.vue";
export default {
  name: "AddNoteModal",
  props: {
    person: {
      type: Object,
      required: true,
    },
  },
  components: {
    NoteForm,
  },
  methods: {
    showModal() {
      this.$refs.addNoteModal.show();
    },
    noteCreatedEvent() {
      this.$refs.addNoteModal.hide();
    },
  },
};
</script>