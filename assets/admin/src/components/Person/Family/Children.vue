<template>
  <b-row>
    <b-col>
      <b-row>
        <b-col>
          <b-button variant="success" @click="addChildren()">
            {{ labels.add }}
          </b-button>
        </b-col>
      </b-row>
      <b-row v-for="child in children" v-bind:key="child.id">
        <b-col cols="10">
          <person-simple-form
            :label="labels.child + ' ' + (index + 1).toString()"
            :familiar="child"
            :person="person"
          ></person-simple-form>
        </b-col>
        <b-col>
          <b-button
            type="button"
            variant="danger"
            @click="removeChildren(index)"
          >
            {{ labels.remove }}
          </b-button>
        </b-col>
      </b-row>
    </b-col>
  </b-row>
</template>
<script>
import PersonSimpleForm from "./PersonSimpleForm.vue";
export default {
  name: "Children",
  components: {
    PersonSimpleForm,
  },
  props: {
    person: {
      type: Object,
      required: false,
      default: null,
    },
  },
  data() {
    return {
      children: [],
    };
  },
  methods: {
    async addChildren() {
      await this.$store.dispatch("familiar/createChild", this.$props.person.id);
      this.$store.dispatch("person/getPerson", this.$props.person.id);
    },
    removeChildren(index) {
      this.children.splice(index, 1);
    },
  },
};
</script>