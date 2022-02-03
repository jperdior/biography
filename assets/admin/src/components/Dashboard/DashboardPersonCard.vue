<template>
<b-card :img-src="person.mainPictureBase64" img-alt="Card image" img-right>

</b-card>
</template>
<script>
export default{
    name: "DashboardPersonCard",
    props:{
        person:{
            type: Object,
            required:true
        }
    }
}
</script>
