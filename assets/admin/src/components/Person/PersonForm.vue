<template>
  <b-container fluid>
    <b-row>
      <b-col>
        <b-form @submit.prevent="submitPerson" @reset="onReset">
          <b-form-group :label="labels.name" label-for="name">
            <b-form-input
              id="name"
              v-model="formPerson.name"
              required
            ></b-form-input>
          </b-form-group>
          <b-form-group :label="labels.lastnames" label-for="lastnames">
            <b-form-input
              id="lastname"
              v-model="formPerson.lastnames"
              required
            ></b-form-input>
          </b-form-group>
          <b-row>
            <b-col
              v-for="(parent, index) in formPerson.parents"
              v-bind:key="parent.id"
            >
              <person-simple-form
                :label="parentLabel(index)"
                :person="formPerson.parents[index]"
              ></person-simple-form>
            </b-col>
          </b-row>
          <b-row>
            <b-col
              v-for="(child, index) in formPerson.children"
              v-bind:key="child.id"
            >
              <person-simple-form
                :label="labels.child + (index + 1).toString()"
                :person="formPerson.children[index]"
              ></person-simple-form>
            </b-col>
          </b-row>
          <b-button type="submit" variant="primary"
            >{{ labels.submit }}
          </b-button>
        </b-form>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import PersonSimpleForm from "./PersonSimpleForm.vue";
export default {
  name: "PersonForm",
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
  computed: {
    labels() {
      return this.$store.getters["person/personLabels"];
    },
  },
  data() {
    return {
      formPerson: {
        name: "",
        lastnames: "",
        parents: [
          {
            name: "",
            lastnames: "",
          },
          {
            name: "",
            lastnames: "",
          },
        ],
        children: [],
      },
      childrenNumber: 0,
    };
  },
  watch: {
    person() {
      if (this.person) {
        this.$data.formPerson = this.person;
        // delete this.$data.formPerson.id;
      }
    },
  },
  methods: {
    async submitPerson() {
      if (this.$props.person) {
        await this.$store.dispatch(
          "person/updatePerson",
          this.$data.formPerson
        );
      } else {
        await this.$store.dispatch(
          "person/createPerson",
          this.$data.formPerson
        );
        this.$data.formPerson = {
          name: "",
          lastnames: "",
          parents: [
            {
              name: "",
              lastnames: "",
            },
            {
              name: "",
              lastnames: "",
            },
          ],
        };
      }
    },
    onReset() {
      if (this.$props.person) {
        this.$data.formPerson = this.$props.person;
        return false;
      }
      this.$data.formPerson = {
        name: "",
        lastnames: "",
        parents: [
          {
            name: "",
            lastnames: "",
          },
          {
            name: "",
            lastnames: "",
          },
        ],
        children: [],
        partner: {
          name: "",
          lastnames: "",
        },
      };
    },
    parentLabel(index) {
      if (index === 0) {
        return this.labels.son_of;
      }
      return this.labels.and_of;
    },
  },
};
</script>