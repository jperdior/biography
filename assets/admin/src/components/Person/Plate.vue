<template>
  <b-row>
    <b-col>
      <div class="plate">
        <b-row>
          <b-col cols="3" class="qr">
            <vue-qr
              :text="'http://memorate.local/#/person/' + person.id"
            ></vue-qr>
          </b-col>
          <b-col class="text-center person-data">
            {{ person.name }} {{ person.lastnames }} <br />
            {{ birthdate }} - {{ deathdate }}
          </b-col>
        </b-row>
      </div>
    </b-col>
  </b-row>
</template>
<script>
import VueQr from "vue-qr";
import moment from "moment";
export default {
  name: "Plate",
  props: {
    person: {
      type: Object,
      required: true,
    },
  },
  components: {
    VueQr,
  },
  computed: {
    birthdate() {
      return moment(this.$props.person.birthdate).format("DD/MM/YYYY");
    },
    deathdate() {
      return moment(this.$props.person.deathdate).format("DD/MM/YYYY");
    },
  },
};
</script>

<style>
.plate {
  border: 1px solid #000;
  width: 680px;
  height: 227px;
  display: block;
}

.qr {
  padding-top: 13px;
  padding-left: 25px;
}

.person-data {
  padding-top: 7%;
  font-size: 34px;
  font-style: italic;
}
</style>