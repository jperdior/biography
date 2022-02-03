<template>
<b-card :img-src="person.mainPictureBase64" img-alt="Card image" img-right>

</b-card>
</template>
<script>
import moment from "moment";
export default{
    name: "DashboardPersonCard",
    props:{
        person:{
            type: Object,
            required:true
        }
    },
    computed:{
        personDeletionDate() {
            if (this.subscription) {
                return moment
                .unix(this.subscription.current_period_end)
                .add(1, "M")
                .format("DD/MM/YYYY");
            }
            return moment(this.mainPerson.created).add(1, "M").format("DD/MM/YYYY");
        },
    }
}
</script>
