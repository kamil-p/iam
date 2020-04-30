<template>
    <div>
        <v-toolbar
                dark
                prominent
                src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
        >

            <v-toolbar-title>Admin panel</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn @click="logout" icon>
                <v-icon>mdi-export</v-icon>
            </v-btn>
        </v-toolbar>
    </div>
</template>

<script>
    import router from "../plugins/router";

    export default {
        name: 'AppBar',

        data: () => ({
        }),
        methods: {
            logout() {
                localStorage.removeItem('user');
                router.push({ name: 'home' });
            }
        },
    }
</script>