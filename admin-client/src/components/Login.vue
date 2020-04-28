<template>
    <v-app id="inspire">
        <v-content>
            <v-container
                    class="fill-height"
                    fluid
            >
                <v-row
                        align="center"
                        justify="center"
                >
                    <v-col
                            cols="12"
                            sm="8"
                            md="4"
                    >
                        <v-card class="elevation-12">
                            <v-toolbar
                                    color="primary"
                                    dark
                                    flat
                            >
                                <v-toolbar-title>Login form</v-toolbar-title>
                                <v-spacer/>
                            </v-toolbar>
                            <v-card-text>
                                <v-form>
                                    <v-text-field
                                            label="Login"
                                            name="login"
                                            prepend-icon="person"
                                            type="text"
                                            v-model="email"
                                    />

                                    <v-text-field
                                            id="password"
                                            label="Password"
                                            name="password"
                                            prepend-icon="lock"
                                            type="password"
                                            v-model="password"
                                    />
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer/>
                                <v-btn color="primary" @click="onSubmit" :loading="loggingIn">Login</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import { mapActions, mapState } from 'vuex'

    export default {
        name: 'Login',
        data() {
            return {
                email: null,
                password: null,
            }
        },
        computed: {
            ...mapState('account', ['loggingIn']),
        },
        created() {
        },
        methods: {
            ...mapActions('account', ['login']),
            onSubmit() {
                this.submitted = true;
                const {email, password} = this;
                if (email && password) {
                    this.login({email, password})
                }
            }
        }
    };
</script>