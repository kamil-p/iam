<template>
    <v-content>
        <AppBar/>
        <router-view></router-view>
    </v-content>
</template>

<script>
    import AppBar from "../components/AppBar";

    export default {
        name: "Panel",
        components: {
            AppBar
        }
    }
</script>

<style scoped>

</style>