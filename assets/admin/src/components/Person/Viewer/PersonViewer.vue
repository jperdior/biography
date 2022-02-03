<template>
  <b-row no-gutters class="mt-5">
    <b-col>
      <b-row no-gutters style="background-color: #afe1af">
        <b-col offset-md="2" md="8">
          <b-row>
            <b-col md="3">
              <b-img
                v-if="person"
                fluid
                :src="person.mainPictureBase64"
              ></b-img>
            </b-col>
            <b-col>
              <h1>{{ person.name }} {{ person.lastnames }}</h1>
              <strong>Nacido el </strong>{{ birthdate }} en
              {{ person.birthplace }}<br />
              <strong>Fallecido el </strong>{{ deathdate }} en
              {{ person.deathplace }}
            </b-col>
          </b-row>
        </b-col>
      </b-row>
      <b-row no-gutters class="pt-4">
        <b-col offset-md="2" md="8">
          <b-row no-gutters>
            <b-col md="3" class="pr-3">
              <b-row>
                <b-col>
                  <FamilyTree
                    v-if="person.parents"
                    :person="person"
                  ></FamilyTree>
                </b-col>
              </b-row>
              <b-row class="mt-2">
                <b-col>
                  <add-calendar-event :person="person"></add-calendar-event>
                </b-col>
              </b-row>
              <b-row class="mt-2">
                <b-col>
                  <b-button> Enviar galería de imágenes </b-button>
                </b-col>
              </b-row>
              <b-row class="mt-2">
                <b-col>
                  <add-note-modal :person="person"></add-note-modal>
                </b-col>
              </b-row>
              <b-row class="mt-2">
                <b-col>
                  <b-button> Crear recuerdo </b-button>
                </b-col>
              </b-row>
              <hr />
              <b-row class="mt-2" v-if="person.nicknames">
                <b-col>
                  <strong>Apodos: </strong>
                  <span
                    v-for="(nickname, i) in person.nicknames"
                    v-bind:key="nickname"
                  >
                    {{ nickname
                    }}<span v-if="i < person.nicknames.length - 1">, </span>
                  </span>
                </b-col>
              </b-row>
              <b-row class="mt-2" v-if="person.favorites">
                <b-col>
                  <b-row
                    v-for="favorite in person.favorites"
                    v-bind:key="favorite.id"
                  >
                    <b-col>
                      <strong>{{ favorite.type }} favoritos:</strong>
                      <span
                        v-for="(fav, i) in favorite.favorites"
                        v-bind:key="fav"
                      >
                        {{ fav
                        }}<span v-if="i < favorite.favorites.length - 1"
                          >,
                        </span>
                      </span>
                    </b-col>
                  </b-row>
                </b-col>
              </b-row>
            </b-col>

            <b-col
              md="9"
              style="border-left: 1px lightgrey solid; padding-left: 10px"
            >
              <b-tabs>
                <b-tab title="Biografía" active>
                  <b-row>
                    <b-col>
                      <h3>Biografía</h3>
                    </b-col>
                  </b-row>
                  <b-row>
                    <b-col v-html="person.description"></b-col>
                  </b-row>
                </b-tab>
                <b-tab title="Notes">
                  <notes :person="person"></notes>
                </b-tab>
              </b-tabs>
            </b-col>
          </b-row>
        </b-col>
      </b-row>
      <b-row no-gutters>
        <b-col>
          <candles></candles>
        </b-col>
      </b-row>
    </b-col>
  </b-row>
</template>
<script>
import moment from "moment";
import FamilyTree from "../Family/FamilyTree.vue";
import AddCalendarEvent from "../AddCalendarEvent.vue";
import AddNoteModal from "../../Note/AddNoteModal.vue";
import Candles from "./Candles.vue";
import Notes from "./Notes.vue";
export default {
  name: "PersonViewer",
  components: {
    FamilyTree,
    AddCalendarEvent,
    AddNoteModal,
    Candles,
    Notes,
  },
  props: {
    person: {
      type: Object,
      required: true,
    },
  },
  computed: {
    personLabels() {
      return this.$store.getters["label/personLabels"];
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