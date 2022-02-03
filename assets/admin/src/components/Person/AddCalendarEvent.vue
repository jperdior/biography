<template>
  <span>
    <b-button @click="showAddEventModal">
      {{ personLabels.add_reminder }}
    </b-button>

    <b-modal
      ref="addEventModal"
      :title="personLabels.reminder_type"
      :hide-footer="true"
    >
      <b-row>
        <b-col>
          <b-form-group>
            <b-form-select
              :options="personLabels.eventTypes"
              v-model="eventType"
            ></b-form-select>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <b-button
            target="_blank"
            variant="primary"
            :href="
              'https://www.google.com/calendar/render?action=TEMPLATE&text=' +
              eventName +
              '&dates=' +
              eventStartDate +
              '/' +
              eventEndDate +
              '&recur=RRULE:FREQ=YEARLY'
            "
          >
            {{ personLabels.google_calendar }}
          </b-button>
          <b-button
            target="_blank"
            variant="primary"
            :href="
              'https://outlook.live.com/calendar/0/deeplink/compose?path=%2Fcalendar%2Faction%2Fcompose&rru=addevent&startdt=' +
              eventDateOutlook +
              '&subject=' +
              eventName +
              '&allday=true'
            "
          >
            Outlook
          </b-button>
          <b-button
            target="_blank"
            variant="primary"
            :href="
              'https://outlook.office.com/calendar/0/deeplink/compose?path=%2Fcalendar%2Faction%2Fcompose&rru=addevent&startdt=' +
              eventDateOutlook +
              '&subject=' +
              eventName +
              '&allday=true'
            "
          >
            Office 365
          </b-button>
        </b-col>
      </b-row>
    </b-modal>
  </span>
</template>
<script>
import moment from "moment";
export default {
  name: "AddCalendarEvent",
  props: {
    person: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      eventType: "birthdate",
    };
  },
  computed: {
    personLabels() {
      return this.$store.getters["label/personLabels"];
    },
    eventName() {
      let eventName = "";
      switch (this.$data.eventType) {
        case "birthdate":
          eventName = "Birth anniversary of ";
          break;
        case "deathdate":
          eventName = "Decease anniversary of ";
          break;
      }
      eventName += this.$props.person.name + " " + this.$props.person.lastnames;
      return eventName;
    },
    birthdate() {
      return moment(this.$props.person.birthdate).format("DD-MM-YYYY");
    },
    deathdate() {
      return moment(this.$props.person.deathdate).format("DD-MM-YYYY");
    },
    eventDateOutlook() {
      let nextDate = null;
      let currentDay = moment().date();
      let currentMonth = moment().month() + 1;
      let currentYear = moment().year();
      switch (this.$data.eventType) {
        case "birthdate":
          let birthDay = moment(this.birthdate, "DD-MM-YYYY").date();
          let birthMonth = moment(this.birthdate, "DD-MM-YYYY").month() + 1;
          if (birthMonth > currentMonth) {
            nextDate = moment(
              birthDay + "-" + birthMonth + "-" + currentYear,
              "DD-MM-YYYY"
            );
          } else if (birthMonth == currentMonth && birthDay > currentDay) {
            nextDate = moment(
              birthDay + "-" + birthMonth + "-" + currentYear,
              "DD-MM-YYYY"
            );
          } else {
            let nextYear = moment().add(1, "Y").year();
            nextDate = moment(
              birthDay + "-" + birthMonth + "-" + nextYear,
              "DD-MM-YYYY"
            );
          }
          break;
        case "deathdate":
          let deathDay = moment(this.deathdate, "DD-MM-YYYY").date();
          let deathMonth = moment(this.deathdate, "DD-MM-YYYY").month() + 1;
          if (deathMonth > currentMonth) {
            nextDate = moment(
              deathDate + "-" + deathMonth + "-" + currentYear,
              "DD-MM-YYYY"
            );
          } else if (deathMonth == currentMonth && deathDay > currentDay) {
            nextDate = moment(
              deathDay + "-" + deathMonth + "-" + currentYear,
              "DD-MM-YYYY"
            );
          } else {
            let nextYear = moment().add(1, "Y").year();
            nextDate = moment(
              deathDay + "-" + deathMonth + "-" + nextYear,
              "DD-MM-YYYY"
            );
          }
          break;
      }
      return nextDate.format("YYYY-MM-DD");
    },
    eventStartDate() {
      let nextDate = null;
      let currentDay = moment().date();
      let currentMonth = moment().month() + 1;
      let currentYear = moment().year();
      switch (this.$data.eventType) {
        case "birthdate":
          let birthDay = moment(this.birthdate, "DD-MM-YYYY").date();
          let birthMonth = moment(this.birthdate, "DD-MM-YYYY").month() + 1;
          if (birthMonth > currentMonth) {
            nextDate = moment(
              birthDay + "-" + birthMonth + "-" + currentYear,
              "DD-MM-YYYY"
            );
          } else if (birthMonth == currentMonth && birthDay > currentDay) {
            nextDate = moment(
              birthDay + "-" + birthMonth + "-" + currentYear,
              "DD-MM-YYYY"
            );
          } else {
            let nextYear = moment().add(1, "Y").year();
            nextDate = moment(
              birthDay + "-" + birthMonth + "-" + nextYear,
              "DD-MM-YYYY"
            );
          }
          break;
        case "deathdate":
          let deathDay = moment(this.deathdate, "DD-MM-YYYY").date();
          let deathMonth = moment(this.deathdate, "DD-MM-YYYY").month() + 1;
          if (deathMonth > currentMonth) {
            nextDate = moment(
              deathDate + "-" + deathMonth + "-" + currentYear,
              "DD-MM-YYYY"
            );
          } else if (deathMonth == currentMonth && deathDay > currentDay) {
            nextDate = moment(
              deathDay + "-" + deathMonth + "-" + currentYear,
              "DD-MM-YYYY"
            );
          } else {
            let nextYear = moment().add(1, "Y").year();
            nextDate = moment(
              deathDay + "-" + deathMonth + "-" + nextYear,
              "DD-MM-YYYY"
            );
          }
          break;
      }
      return nextDate.format("YYYYDDMM");
    },
    eventEndDate() {
      let nextDate = null;
      let currentDay = moment().date();
      let currentMonth = moment().month() + 1;
      let currentYear = moment().year();
      switch (this.$data.eventType) {
        case "birthdate":
          let birthDay = moment(this.birthdate, "DD-MM-YYYY").date();
          let birthMonth = moment(this.birthdate, "DD-MM-YYYY").month() + 1;
          if (birthMonth > currentMonth) {
            nextDate = moment(
              birthDay + "-" + birthMonth + "-" + currentYear,
              "DD-MM-YYYY"
            );
          } else if (birthMonth == currentMonth && birthDay > currentDay) {
            nextDate = moment(
              birthDay + "-" + birthMonth + "-" + currentYear,
              "DD-MM-YYYY"
            );
          } else {
            let nextYear = moment().add(1, "Y").year();
            nextDate = moment(
              birthDay + "-" + birthMonth + "-" + nextYear,
              "DD-MM-YYYY"
            );
          }
          nextDate = nextDate.add(1, "d");
          break;
        case "deathdate":
          let deathDay = moment(this.deathdate, "DD-MM-YYYY").date();
          let deathMonth = moment(this.deathdate, "DD-MM-YYYY").month() + 1;
          if (deathMonth > currentMonth) {
            nextDate = moment(
              deathDay + "-" + deathMonth + "-" + currentYear,
              "DD-MM-YYYY"
            );
          } else if (deathMonth == currentMonth && deathDay > currentDay) {
            nextDate = moment(
              deathDay + "-" + deathMonth + "-" + currentYear,
              "DD-MM-YYYY"
            );
          } else {
            let nextYear = moment().add(1, "Y").year();
            nextDate = moment(
              deathDay + "-" + deathMonth + "-" + nextYear,
              "DD-MM-YYYY"
            );
          }
          nextDate = nextDate.add(1, "d");
          break;
      }
      return nextDate.format("YYYYDDMM");
    },
  },
  methods: {
    showAddEventModal() {
      this.$refs.addEventModal.show();
    },
  },
};
</script>