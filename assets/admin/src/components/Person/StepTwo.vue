<template>
  <b-container>
    <b-row>
      <b-col>
        <FamilyTree :person="person"></FamilyTree>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <!-- Parents -->
        <b-row>
          <b-col>
            <h4>{{ labels.parents }}</h4>
          </b-col>
        </b-row>

        <b-row>
          <b-col
            v-for="(parent, index) in formPerson.parents"
            v-bind:key="parent.id"
          >
            <b-card>
              <person-simple-form
                :label="parentLabel(index)"
                :familiar="formPerson.parents[index]"
                :person="person"
              ></person-simple-form>
            </b-card>
          </b-col>
        </b-row>
        <hr />
        <!-- Children -->
        <b-row>
          <b-col>
            <h4>{{ labels.children }}</h4>
          </b-col>
          <b-col>
            <b-button variant="success" @click="addChild()">
              {{ labels.add }}
            </b-button>
          </b-col>
        </b-row>
        <b-row>
          <b-col
            v-for="(child, index) in formPerson.children"
            v-bind:key="child.id"
            cols="6"
          >
            <b-card>
              <person-simple-form
                :label="labels.child + ' ' + (index + 1).toString()"
                :familiar="formPerson.children[index]"
                :person="person"
              ></person-simple-form>
            </b-card>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
    <hr />
    <b-row>
      <b-col>
        <b-button @click="submitPerson()">
          {{ labels.save }}
        </b-button>
        <b-button v-if="person" @click="submitPerson(true)">
          {{ labels.save_and_continue }}
        </b-button>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import PersonSimpleForm from "./Family/PersonSimpleForm.vue";
import FamilyTree from "./Family/FamilyTree.vue";
export default {
  name: "StepTwo",
  components: {
    PersonSimpleForm,
    FamilyTree,
  },
  props: {
    person: {
      type: Object,
      required: true,
      default: null,
    },
  },
  data() {
    return {
      formPerson: {
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
    };
  },
  computed: {
    labels() {
      return this.$store.getters["person/personLabels"];
    },
  },
  created() {
    if (this.person) {
      this.$data.formPerson = this.person;
      if (!this.$data.formPerson.parents.length) {
        this.$data.formPerson.parents = [
          {
            name: "",
            lastnames: "",
          },
          {
            name: "",
            lastnames: "",
          },
        ];
      }
    }
  },
  watch: {
    person() {
      if (this.person) {
        this.$data.formPerson = this.person;
      }
    },
  },
  methods: {
    async submitPerson(nextStep = false) {
      const response = await this.$store.dispatch(
        "person/updatePerson",
        this.$data.formPerson
      );
      if (response.status === 200) {
        this.$toasted.success(this.labels.saved_successfully, {
          duration: 5000,
          theme: "bubble",
        });
        this.$store.dispatch("person/getPerson", this.$props.person.id);
        if (nextStep) {
          this.$emit("next");
        }
      }
    },
    parentLabel(index) {
      if (index === 0) {
        return this.labels.son_of;
      }
      return this.labels.and_of;
    },
    async addChild() {
      await this.submitPerson();
      await this.$store.dispatch("familiar/createChild", this.$props.person.id);
      await this.$store.dispatch("person/getPerson", this.$props.person.id);
    },
    removeChild(index) {
      this.$data.formPerson.children.splice(index, 1);
    },
  },
};
</script>