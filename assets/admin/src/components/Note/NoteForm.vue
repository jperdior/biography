<template>
  <b-row>
    <b-col>
      <b-form @submit.prevent="submitNote">
        <b-form-group :label="defaultLabels.email">
          <b-form-input v-model="note.email" placeholder="Email" required />
        </b-form-group>
        <b-form-group :label="defaultLabels.fullname">
          <b-form-input
            v-model="note.fullname"
            placeholder="Fullname"
            required
          />
        </b-form-group>
        <!-- <b-form-group>
          <b-form-input v-model="note.title" placeholder="Título" required />
        </b-form-group> -->
        <b-form-group>
          <b-form-textarea v-model="note.body" placeholder="Nota" required />
        </b-form-group>
        <b-form-group>
          <b-button type="submit" variant="primary"> Enviar </b-button>
        </b-form-group>
      </b-form>
    </b-col>
  </b-row>
</template>
<script>
export default {
  name: "NoteForm",
  props: {
    person: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      note: {
        email: "",
        fullname: "",
        // title: "",
        body: "",
      },
    };
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
    async submitNote() {
      const response = await this.$store.dispatch("note/createNote", {
        personId: this.$props.person.id,
        note: this.$data.note,
      });
      this.$emit("noteCreated");
    },
  },
};
</script>