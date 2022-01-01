<template>
  <b-container fluid>
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
        <!-- Step 1 -->
        <b-row v-if="currentStep == 1">
          <step-one @next="nextStep" :person="person"></step-one>
        </b-row>
        <!-- Step 2 -->

        <b-row v-if="currentStep == 2">
          <step-two @next="nextStep" :person="person"></step-two>
        </b-row>

        <!--- Step 3 -->

        <b-row v-if="currentStep == 3">
          <step-three @next="nextStep" :person="person"> </step-three>
        </b-row>

        <!-- Step 4 -->
        <b-row v-if="currentStep == 4">
          <step-four @next="nextStep" :person="person"></step-four>
        </b-row>

        <!-- Controls -->
        <b-button
          variant="primary"
          @click="previousStep()"
          v-if="currentStep > 1"
        >
          {{ labels.previous }}
        </b-button>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import StepOne from "./StepOne.vue";
import StepTwo from "./StepTwo.vue";
import StepThree from "./StepThree.vue";
import StepFour from "./StepFour.vue";
import vueStep from "vue-step";
export default {
  name: "PersonForm",
  components: {
    vueStep,
    StepOne,
    StepTwo,
    StepThree,
    StepFour,
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
      birthdateString: null,
      birthdate: null,
      birthdateState: null,
      deathdateString: null,
      deathdateState: null,
      deathdate: null,
      favorites: [],
      formPerson: {
        treatment: 2,
        name: "",
        lastnames: "",
        birthdate: "",
        birthplace: "",
        deathdate: "",
        deathplace: "",
        description: "",
        nicknames: [],
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
  methods: {
    nextStep() {
      this.$data.currentStep = this.$data.currentStep + 1;
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

    previousStep() {
      this.$data.currentStep--;
    },
    moment: function () {
      return moment();
    },
  },
};
</script>