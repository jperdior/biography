<template>
  <b-row>
    <b-col>
      <b-row>
        <b-col>
          <b-form-group :label="labels.nicknames" label-for="nicknames">
            <b-form-tags
              id="nicknames"
              separator=","
              :placeholder="labels.nicknames_placeholder"
              v-model="formPerson.nicknames"
            ></b-form-tags>
          </b-form-group>
        </b-col>
      </b-row>
      <hr />
      <b-row>
        <b-col>
          <b-form-group :label="labels.description" label-for="description">
            <quill-editor
              ref="myQuillEditor"
              v-model="formPerson.description"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <hr />
      <b-row>
        <b-col>
          <Favorites
            @favoritesChanged="favoritesChangedEvent"
            :person="person"
          ></Favorites>
        </b-col>
      </b-row>
      <hr />
      <b-row>
        <b-col>
          <b-button @click="submitPerson()">
            {{ defaultLabels.save }}
          </b-button>
          <b-button v-if="person" @click="submitPerson(true)">
            {{ defaultLabels.save_and_continue }}
          </b-button>
        </b-col>
      </b-row>
    </b-col>
  </b-row>
</template>

<script>
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";

import { quillEditor } from "vue-quill-editor";
import Favorites from "../Favorites.vue";
export default {
  name: "StepThree",
  components: {
    quillEditor,
    Favorites,
  },
  props: {
    person: {
      type: Object,
      required: true,
      default: null,
    },
  },
  mounted() {
    if (this.person) {
      this.$data.formPerson = this.person;
      if (!this.$data.formPerson.description) {
        this.processDefaultDescription();
      }
    }
  },
  data() {
    return {
      formPerson: {
        description: "",
        favorites: [],
      },
    };
  },
  computed: {
    labels() {
      return this.$store.getters["label/personLabels"];
    },
    defaultLabels() {
      return this.$store.getters["label/defaultLabels"];
    },
  },
  methods: {
    favoritesChangedEvent(favorites) {
      this.$data.formPerson.favorites = favorites;
    },
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
        console.log(nextStep);
        if (nextStep) {
          this.$emit("next");
        }
      }
    },
  },
};
</script>