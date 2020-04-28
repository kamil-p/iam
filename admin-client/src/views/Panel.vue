<template>
    <v-content>
        <AppBar/>
        <Table></Table>
    </v-content>
</template>

<script>
    import AppBar from "../components/AppBar";
    import Table from "../components/Table";

    export default {
        name: "Panel",
        components: {
            Table,
            AppBar
        }
    }
</script>

<style scoped>

</style>