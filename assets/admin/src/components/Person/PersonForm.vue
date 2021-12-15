<template>
  <b-container v-if="!isLoading">
    <b-row>
      <b-col>
        <vue-step
          v-if="labels"
          :now-step="currentStep"
          :step-list="labels.stepTitles"
          active-color="#E92457"
        ></vue-step>
      </b-col>
    </b-row>
    <b-row >
      <b-col>
        <b-form @submit.prevent="submitPerson" @reset="onReset">
          <!-- Step 1 -->
          <b-row v-show="currentStep == 1">
            <b-col>
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
            </b-col>
          </b-row>
          <!-- Step 2 -->
          <!-- Parents -->
          <b-row v-show="currentStep == 2">
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
          <!-- Children -->
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
          <!-- Controls -->
          <b-button type="submit" variant="primary"
            >{{ labels.save_and_continue }}
          </b-button>
          <b-button type="submit" variant="primary"
            >{{ labels.save }}
          </b-button>
        </b-form>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import PersonSimpleForm from "./PersonSimpleForm.vue";
import vueStep from "vue-step";
export default {
  name: "PersonForm",
  components: {
    PersonSimpleForm,
    vueStep
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
    isLoading(){
      return this.$store.getters["person/loading"];
    }
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
      currentStep: 1,
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
        const response = await this.$store.dispatch(
          "person/createPerson",
          this.$data.formPerson
        );
        console.log(response);
        this.$router.push({
            name: "EditPerson",
            params:{
                id: response.id
            }
          });
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