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
    <b-row>
      <b-col>
        <b-form
          ref="personForm"
          @submit.prevent="submitPerson"
          @reset="onReset"
        >
          <!-- Step 1 -->
          <b-row v-if="currentStep == 1">
            <b-col>
              <b-form-group :label="labels.treatment" label-for="treatment">
                <b-form-select
                  id="treatment"
                  v-model="formPerson.treatment"
                  :options="labels.treatments"
                  required
                ></b-form-select>
              </b-form-group>
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
              <b-form-group :label="labels.birthdate" label-for="birthdate">
                <b-form-datepicker
                  id="birthdate"
                  v-model="formPerson.birthdate"
                  required
                  placeholder="dd/mm/yyyy"
                ></b-form-datepicker>
              </b-form-group>
              <b-form-group :label="labels.birthplace" label-for="birthplace">
                <b-form-input
                  id="birthplace"
                  v-model="formPerson.birthplace"
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group :label="labels.deathdate" label-for="deathdate">
                <b-form-datepicker
                  id="deathdate"
                  v-model="formPerson.deathdate"
                  required
                  placeholder="dd/mm/yyyy"
                ></b-form-datepicker>
              </b-form-group>
              <b-form-group :label="labels.deathplace" label-for="deathplace">
                <b-form-input
                  id="deathplace"
                  v-model="formPerson.deathplace"
                  required
                ></b-form-input>
              </b-form-group>
            </b-col>
          </b-row>
          <!-- Step 2 -->

          <b-row v-if="currentStep == 2">
            <b-col>
              <!-- Parents -->
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
              <!-- Children -->
              <b-row>
                <b-col>
                  {{ labels.children }}
                </b-col>
                <b-col>
                  <b-button variant="success" @click="addChild()">
                    {{ labels.add }}
                  </b-button>
                </b-col>
              </b-row>
              <b-row
                v-for="(child, index) in formPerson.children"
                v-bind:key="child.id"
              >
                <b-col cols="10">
                  <person-simple-form
                    :label="labels.child + ' ' + (index + 1).toString()"
                    :person="formPerson.children[index]"
                  ></person-simple-form>
                </b-col>
                <b-col>
                  <b-button
                    type="button"
                    variant="danger"
                    @click="removeChild(index)"
                  >
                    {{ labels.remove }}
                  </b-button>
                </b-col>
              </b-row>
            </b-col>
            <b-row>
              <b-col>
                <FamilyTree :person="person"></FamilyTree>
              </b-col>
            </b-row>
          </b-row>

          <!--- Step 3 -->
          <b-row v-if="currentStep == 3" style="min-height: 400px">
            <b-col>
              <b-form-group :label="labels.description" label-for="description">
                <quill-editor
                  ref="myQuillEditor"
                  v-model="formPerson.description"
                  style="min-height: 400px"
                />
              </b-form-group>
            </b-col>
          </b-row>

          <!-- Step 4 -->
          <galleries v-if="currentStep == 4" :person="person"></galleries>

          <!-- Controls -->
          <b-button
            variant="primary"
            @click="previousStep()"
            v-if="currentStep > 1"
          >
            {{ labels.previous }}
          </b-button>
          <b-button variant="primary" type="submit" v-if="currentStep < 4">
            {{ labels.next }}
          </b-button>
        </b-form>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";

import { quillEditor } from "vue-quill-editor";
import PersonSimpleForm from "./PersonSimpleForm.vue";
import Galleries from "./Galleries.vue";
import vueStep from "vue-step";
import FamilyTree from "./FamilyTree.vue";
export default {
  name: "PersonForm",
  components: {
    PersonSimpleForm,
    vueStep,
    Galleries,
    quillEditor,
    FamilyTree,
  },
  mounted: function () {
    if (this.$route.params.step) {
      this.currentStep = parseInt(this.$route.params.step);
    }
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
    isLoading() {
      return this.$store.getters["person/loading"];
    },
  },
  data() {
    return {
      formPerson: {
        treatment: 2,
        name: "",
        lastnames: "",
        birthdate: "",
        birthplace: "",
        deathdate: "",
        deathplace: "",
        description: "",
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
        if (!this.$data.formPerson.description) {
          this.processDefaultDescription();
        }
        // delete this.$data.formPerson.id;
      }
    },
  },
  methods: {
    processDefaultDescription() {
      this.$data.formPerson.description = this.labels.default_description;
      //PERSON
      this.$data.formPerson.description =
        this.$data.formPerson.description.replace(
          "NAME_PLACEHOLDER",
          this.$data.formPerson.name
        );
      this.$data.formPerson.description =
        this.$data.formPerson.description.replace(
          "LASTNAME_PLACEHOLDER",
          this.$data.formPerson.lastnames
        );
      //DATES AND PLACES
      let birthDate = new Date(this.$data.formPerson.birthdate);
      let birthDateString =
        birthDate.getDate() +
        "/" +
        (birthDate.getMonth() + 1) +
        "/" +
        birthDate.getFullYear();
      this.$data.formPerson.description =
        this.$data.formPerson.description.replace(
          "BIRTHDATE_PLACEHOLDER",
          birthDateString
        );
      this.$data.formPerson.description =
        this.$data.formPerson.description.replace(
          "BIRTHPLACE_PLACEHOLDER",
          this.$data.formPerson.birthplace
        );
      let deathDate = new Date(this.$data.formPerson.deathdate);
      let deathDateString =
        deathDate.getDate() +
        "/" +
        (deathDate.getMonth() + 1) +
        "/" +
        deathDate.getFullYear();
      this.$data.formPerson.description =
        this.$data.formPerson.description.replace(
          "DEATHDATE_PLACEHOLDER",
          deathDateString
        );
      this.$data.formPerson.description =
        this.$data.formPerson.description.replace(
          "DEATHPLACE_PLACEHOLDER",
          this.$data.formPerson.deathplace
        );
      //PARENTS
      let parentsString = "";
      if (this.$data.formPerson.parents[0].name) {
        parentsString +=
          this.labels.son_of +
          " <strong>" +
          this.$data.formPerson.parents[0].name +
          " " +
          this.$data.formPerson.parents[0].lastnames +
          "</strong>";
      }
      if (this.$data.formPerson.parents[1].name) {
        parentsString +=
          " " +
          this.labels.and_of +
          " <strong>" +
          this.$data.formPerson.parents[1].name +
          " " +
          this.$data.formPerson.parents[1].lastnames +
          "</strong>";
      }
      this.$data.formPerson.description =
        this.$data.formPerson.description.replace(
          "PARENTS_PLACEHOLDER",
          parentsString
        );
      //CHILDREN
      let childrenString = "";
      if (this.$data.formPerson.children.length > 0) {
        childrenString += this.getParentTreatment() + " ";
        for (let i = 0; i < this.$data.formPerson.children.length; i++) {
          childrenString +=
            "<strong>" +
            this.$data.formPerson.children[i].name +
            " " +
            this.$data.formPerson.children[i].lastnames +
            "</strong>";
          if (i < this.$data.formPerson.children.length - 2) {
            childrenString += ", ";
          }
          if (i == this.$data.formPerson.children.length - 2) {
            childrenString += " " + this.labels.and + " ";
          }
        }
        childrenString += ".";
      }
      this.$data.formPerson.description =
        this.$data.formPerson.description.replace(
          "CHILDREN_PLACEHOLDER",
          childrenString
        );
    },
    getParentTreatment() {
      if (this.$data.formPerson.treatment == 0) {
        return this.labels.father_of;
      }
      if (this.$data.formPerson.treatment == 1) {
        return this.labels.mother_of;
      }
      if (this.$data.formPerson.treatment == 2) {
        return this.labels.parent_to;
      }
    },
    async submitPerson() {
      if (this.$props.person) {
        const response = await this.$store.dispatch(
          "person/updatePerson",
          this.$data.formPerson
        );
        if (response.status === 200) {
          this.$toasted.success(this.labels.saved_successfully, {
            duration: 5000,
            theme: "bubble",
          });
          this.$data.currentStep = this.$data.currentStep + 1;
        }
      } else {
        const response = await this.$store.dispatch(
          "person/createPerson",
          this.$data.formPerson
        );
        if (response.status === 201) {
          this.$toasted.success(this.labels.saved_successfully);
          this.$router.push({
            name: "EditPerson",
            params: {
              id: response.data.id,
              step: 2,
            },
          });
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
    addChild() {
      this.$data.formPerson.children.push({
        name: "",
        lastnames: "",
      });
    },
    removeChild(index) {
      this.$data.formPerson.children.splice(index, 1);
    },
    parentLabel(index) {
      if (index === 0) {
        return this.labels.son_of;
      }
      return this.labels.and_of;
    },
    previousStep() {
      this.$data.currentStep--;
    },
  },
};
</script>