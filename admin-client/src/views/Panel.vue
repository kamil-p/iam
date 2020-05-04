<template>
    <v-content>
        <AppBar/>
        <v-container>
            <router-view></router-view>
        </v-container>
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