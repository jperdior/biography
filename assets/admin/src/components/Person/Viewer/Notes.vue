<template>
  <b-row no-gutters>
    <b-col>
      <b-card
        v-for="note in notes"
        v-bind:key="note.id"
        :title="note.fullname"
        class="mt-4"
      >
        <b-card-text>
          {{ note.body }}
        </b-card-text>
      </b-card>
    </b-col>
  </b-row>
</template>
<script>
export default {
  name: "Notes",
  props: {
    person: {
      type: Object,
      required: true,
    },
  },
  created() {
    this.$store.dispatch("note/getNotes", this.$props.person.id);
  },
  computed: {
    notes() {
      return this.$store.getters["note/notes"];
    },
  },
};
</script>