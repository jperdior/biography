<template>
  <b-row class="mb-5">
    <b-col>
      <b-row>
        <b-col>
          <h3>{{ productLabels.customize_memorial_plate }}</h3>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <b-form-group :label="productLabels.choose_font">
            <b-form-select v-model="fontSelected">
              <b-form-select-option
                v-for="fontOption in fontOptions"
                v-bind:key="fontOption.value"
                :value="fontOption.value"
              >
                {{ fontOption.text }}
              </b-form-select-option>
            </b-form-select>
          </b-form-group>
        </b-col>
        <b-col>
          <b-form-group :label="productLabels.choose_material">
            <b-form-select
              v-model="materialSelected"
              :options="productLabels.material_options"
            >
            </b-form-select>
          </b-form-group>
        </b-col>
        <b-col>
          <b-form-group :label="productLabels.choose_size">
            <b-form-select
              v-model="sizeSelected"
              :options="sizeOptions"
            ></b-form-select>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <div :class="'plate ' + materialSelected">
            <b-row>
              <b-col cols="3" class="qr">
                <qr-code
                  :text="'http://memorate.local/#/person/' + person.id"
                  bg-color="rgba(0,255,0,0)"
                  :size="175"
                ></qr-code>
              </b-col>
              <b-col class="text-center person-data" :style="plateStyle">
                {{ person.name }} {{ person.lastnames }} <br />
                {{ birthdate }} - {{ deathdate }}
              </b-col>
            </b-row>
          </div>
        </b-col>
      </b-row>
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
  data() {
    return {
      fontOptions: [
        {
          value: "arial",
          text: "Arial",
        },
        {
          value: "mea_culpa",
          text: "Mea Culpa",
        },
      ],
      fontSelected: "arial",
      materialSelected: "brass",
      sizeOptions: [
        {
          value: "s260x100",
          text: "260 x 100 mm",
        },
        {
          value: "s150x180",
          text: "150 x 180 mm",
        },
      ],
      sizeSelected: "260 x 100 mm",
    };
  },
  computed: {
    birthdate() {
      return moment(this.$props.person.birthdate).format("DD/MM/YYYY");
    },
    deathdate() {
      return moment(this.$props.person.deathdate).format("DD/MM/YYYY");
    },
    productLabels() {
      return this.$store.getters["label/productLabels"];
    },
    plateStyle() {
      switch (this.$data.fontSelected) {
        case "mea_culpa":
          return "font-family: 'Mea Culpa', cursive; font-size:45px;";
      }
      return "font-family: 'Arial'";
    },
  },
};
</script>

<style>
.plate {
  width: 680px;
  height: 227px;
  display: block;
}

.brass {
  background-image: url("../../../public/img/brass.jpg");
  background-size: cover;
}

.steel {
  background-image: url("../../../public/img/steel.jpg");
  background-size: cover;
}

.aluminum {
  background-image: url("../../../public/img/aluminum.jpg");
  background-size: cover;
}

.qr {
  padding-top: 13px;
  padding-left: 25px;
}

.qr div {
  padding-top: 13px;
  padding-left: 13px;
}

.person-data {
  padding-top: 7%;
  font-size: 34px;
  font-style: italic;
}
</style>