<template>
    <v-content>
        <AppBar/>
        <Snackbar/>
        <v-container>
            <router-view></router-view>
        </v-container>
    </v-content>
</template>

<script>
    import AppBar from "../components/AppBar";
    import Snackbar from "../components/Snackbar";

    export default {
        name: "Panel",
        components: {
            AppBar,
            Snackbar
        }
    }
</script>

<style scoped>

</style>