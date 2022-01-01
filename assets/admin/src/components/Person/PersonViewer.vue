<template>
  <b-container>
    <b-row>
      <b-col md="3">
        <b-row>
          <b-col>
            <b-img v-if="person" fluid :src="person.mainPictureBase64"></b-img>
          </b-col>
        </b-row>
        <b-row>
          <b-col> {{ person.name }} {{ person.lastnames }} </b-col>
        </b-row>
        <b-row>
          <b-col>
            <strong>Born: </strong>{{ birthdate }} - {{ person.birthplace }}
          </b-col>
        </b-row>
        <b-row>
          <b-col>
            <strong>Death: </strong>{{ deathdate }} - {{ person.deathplace }}
          </b-col>
        </b-row>
        <b-row v-if="person.parents">
          <b-col>
            <FamilyTree :person="person"></FamilyTree>
          </b-col>
        </b-row>
      </b-col>
      <b-col v-html="person.description" md="9"> </b-col>
    </b-row>

    <b-row>
      <b-col md="8" offset-md="1">
        <b-card>
          <b-row>
            <b-col cols="4">
              <vue-qr
                :text="'http://localhost:8000/#/person/' + person.id"
              ></vue-qr>
            </b-col>
            <b-col cols="8"> {{ person.name }} {{ person.lastnames }} </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import moment from "moment";
import VueQr from "vue-qr";
import FamilyTree from "./Family/FamilyTree.vue";
export default {
  name: "PersonViewer",
  components: {
    VueQr,
    FamilyTree,
  },
  props: {
    person: {
      type: Object,
      required: true,
    },
  },
  computed: {
    labels() {
      return this.$store.getters["person/personLabels"];
    },
    birthdate() {
      return moment(this.$props.person.birthdate).format("DD-MM-YYYY");
    },
    deathdate() {
      return moment(this.$props.person.deathdate).format("DD-MM-YYYY");
    },
  },
  methods: {},
};
</script>