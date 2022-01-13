<template>
  <b-row no-gutters>
    <b-col>
      <b-table :items="notes" :fields="noteLabels.admin_table_fields">
        <template v-slot:cell(actions)="row">
          <approve-disapprove-note
            @statusChanged="refreshList"
            :note="row.item"
          ></approve-disapprove-note>
          <delete-note @deleted="refreshList" :note="row.item"></delete-note>
        </template>
      </b-table>
    </b-col>
  </b-row>
</template>
<script>
import ApproveDisapproveNote from "./ApproveDisapproveNote.vue";
import DeleteNote from "./DeleteNote.vue";
export default {
  name: "NotesAdminList",
  components: {
    ApproveDisapproveNote,
    DeleteNote,
  },
  computed: {
    notes() {
      return this.$store.getters["note/notes"];
    },
    noteLabels() {
      return this.$store.getters["label/noteLabels"];
    },
    defaultLabels() {
      return this.$store.getters["label/defaultLabels"];
    },
  },
  methods: {
    async refreshList() {
      await this.$store.dispatch("note/getAdminNotes");
    },
  },
};
</script>