<template>
  <b-container>
    <b-row>
      <b-col md="3">
        <b-row v-if="person">
          <b-col>
            <person-main-picture :person="person"></person-main-picture>
          </b-col>
        </b-row>
      </b-col>
      <b-col>
        <b-row>
          <b-col md="2">
            <b-form-group :label="labels.treatment" label-for="treatment">
              <b-form-select
                id="treatment"
                v-model="formPerson.treatment"
                :options="labels.treatments"
                required
              ></b-form-select>
            </b-form-group>
          </b-col>
          <b-col md="5">
            <b-form-group :label="labels.name" label-for="name">
              <b-form-input
                id="name"
                v-model="formPerson.name"
                required
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col md="5">
            <b-form-group :label="labels.lastnames" label-for="lastnames">
              <b-form-input
                id="lastname"
                v-model="formPerson.lastnames"
                required
              ></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>
        <b-row>
          <b-col md="6">
            <b-form-group :label="labels.birthdate" label-for="birthdate">
              <b-input-group>
                <b-form-input
                  id="birthdate-input"
                  v-model="birthdateString"
                  :state="birthdateState"
                  type="text"
                  placeholder="DD-MM-YYYY"
                  autocomplete="off"
                ></b-form-input>
                <b-input-group-append>
                  <b-form-datepicker
                    v-model="birthdate"
                    button-only
                    :date-format-options="{
                      day: '2-digit',
                      month: '2-digit',
                      year: 'numeric',
                    }"
                    right
                    locale="es"
                    aria-controls="birthdate-input"
                  ></b-form-datepicker>
                </b-input-group-append>
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col md="6">
            <b-form-group :label="labels.birthplace" label-for="birthplace">
              <b-form-input
                id="birthplace"
                v-model="formPerson.birthplace"
                required
              ></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>
        <b-row>
          <b-col md="6">
            <b-form-group :label="labels.deathdate" label-for="deathdate">
              <b-input-group>
                <b-form-input
                  id="deathdate-input"
                  v-model="deathdateString"
                  type="text"
                  placeholder="DD-MM-YYYY"
                  autocomplete="off"
                ></b-form-input>
                <b-input-group-append>
                  <b-form-datepicker
                    v-model="deathdate"
                    button-only
                    :date-format-options="{
                      day: '2-digit',
                      month: '2-digit',
                      year: 'numeric',
                    }"
                    right
                    locale="es"
                    aria-controls="deathdate-input"
                  ></b-form-datepicker>
                </b-input-group-append>
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col md="6">
            <b-form-group :label="labels.deathplace" label-for="deathplace">
              <b-form-input
                id="deathplace"
                v-model="formPerson.deathplace"
                required
              ></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <h3>{{ labels.privacy_configuration }}</h3>
        <b-row>
          <b-col>
            <b-form-group :label="labels.private_memorial">
              <b-form-checkbox
                v-model="formPerson.needsLogin"
              ></b-form-checkbox>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group :label="labels.allow_notes_or_galleries">
              <b-form-checkbox
                v-model="formPerson.allowNotesOrGalleries"
              ></b-form-checkbox>
            </b-form-group>
          </b-col>
        </b-row>
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
  </b-container>
</template>
<script>
import moment from "moment";
import PersonMainPicture from "./PersonMainPicture.vue";
export default {
  name: "StepOne",
  components: {
    PersonMainPicture,
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
      stepFields: [
        "treatment",
        "name",
        "lastnames",
        "birthdate",
        "birthplace",
        "deathdate",
        "deathplace",
        "needsLogin",
        "allowNotesOrGalleries",
      ],
      formDirty: false,
      birthdateString: null,
      birthdate: null,
      birthdateState: null,
      deathdateString: null,
      deathdateState: null,
      deathdate: null,
      formPerson: {
        treatment: 2,
        name: "",
        lastnames: "",
        birthdate: "",
        birthplace: "",
        deathdate: "",
        deathplace: "",
        needsLogin: null,
        allowNotesOrGalleries: null,
      },
    };
  },
  mounted() {
    for (const key of Object.keys(this.$data.formPerson)) {
      this.$watch(
        `formPerson.${key}`,
        () => {
          if (this.$data.formPerson[key] != this.$props.person[key]) {
            this.$data.formDirty = true;
          } else {
            this.$data.formDirty = false;
          }
        },
        { deep: true }
      );
    }
    if (this.person) {
      for (const key of Object.keys(this.$data.formPerson)) {
        if (this.$data.stepFields.includes(key)) {
          this.$data.formPerson[key] = this.person[key];
        }
      }
      // this.$data.formPerson = this.$props.person;
      if (this.$props.person.birthdate) {
        this.$data.birthdate = this.$props.person.birthdate;
      }
      if (this.$props.person.deathdate) {
        this.$data.deathdate = this.$props.person.deathdate;
      }
    }
  },
  computed: {
    labels() {
      return this.$store.getters["label/personLabels"];
    },
    defaultLabels() {
      return this.$store.getters["label/defaultLabels"];
    },
  },
  watch: {
    person() {
      if (this.person) {
        // this.$data.formPerson = this.$props.person;
        for (const key of Object.keys(this.$data.formPerson)) {
          if (this.$data.stepFields.includes(key)) {
            this.$data.formPerson[key] = this.person[key];
          }
        }
        if (this.$props.person.birthdate) {
          this.$data.birthdate = this.$props.person.birthdate;
        }
        if (this.$props.person.deathdate) {
          this.$data.deathdate = this.$props.person.deathdate;
        }
      }
    },
    birthdate() {
      this.$data.formPerson.birthdate = this.birthdate;
      this.$data.birthdateString = moment(this.birthdate).format("DD-MM-YYYY");
    },
    birthdateString() {
      let date = moment.utc(this.birthdateString, "DD-MM-YYYY", true);
      if (date.isValid()) {
        this.$data.formPerson.birthdate = date;
        this.$data.birthdateState = null;
      } else {
        if (this.$data.birthdateString) {
          this.$data.birthdateState = false;
        }
      }
    },
    deathdate() {
      this.$data.formPerson.deathdate = this.deathdate;
      this.$data.deathdateString = moment(this.deathdate).format("DD-MM-YYYY");
    },
    deathdateString() {
      let date = moment.utc(this.deathdateString, "DD-MM-YYYY", true);
      if (date.isValid()) {
        this.$data.formPerson.deathdate = date;
        this.$data.deathdateState = null;
      } else {
        if (this.$data.deathdateString) {
          this.$data.deathdateState = false;
        }
      }
    },
  },
  methods: {
    async submitPerson(nextStep = false) {
      if (!this.$data.formDirty) {
        if (nextStep) {
          this.$emit("next");
        }
        return;
      }
      if (this.$props.person) {
        this.$data.formPerson.id = this.$props.person.id;
        const response = await this.$store.dispatch(
          "person/updatePerson",
          this.$data.formPerson
        );
        if (response.status === 200) {
          this.$toasted.success(this.labels.saved_successfully, {
            duration: 5000,
            theme: "bubble",
          });
          // this.$store.dispatch("person/getPerson", this.$route.params.id);
          if (nextStep) {
            this.$emit("next");
          }
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
  },
};
</script>