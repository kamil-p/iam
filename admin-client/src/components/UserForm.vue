<template>
    <ValidationObserver ref="observer" >
        <form>
            <ValidationProvider v-slot="{ errors }" name="email" rules="required|email">
                <v-text-field
                        v-model="email"
                        :error-messages="errors"
                        label="E-mail"
                        required
                ></v-text-field>
            </ValidationProvider>
            <v-select
                    v-model="select"
                    :items="roles"
                    label="Roles"
                    data-vv-name="select"
                    solo
            ></v-select>
            <v-text-field
                    v-model="createdAt"
                    label="Created at"
                    solo
                    disabled
            ></v-text-field>
            <v-text-field
                    v-model="updatedAt"
                    label="Updated at"
                    solo
                    disabled
            ></v-text-field>

            <v-btn class="mr-4" @click="submit">submit</v-btn>
        </form>
    </ValidationObserver>
</template>

<script>
    import { required, email, max } from 'vee-validate/dist/rules'
    import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'
    import iamClient from "../services/iamClient";

    setInteractionMode('eager')
    extend('required', {
        ...required,
        message: '{_field_} can not be empty',
    })
    extend('max', {
        ...max,
        message: '{_field_} may not be greater than {length} characters',
    })
    extend('email', {
        ...email,
        message: 'Email must be valid',
    })

    export default {
        name: 'UserForm',
        components: {
            ValidationProvider,
            ValidationObserver,
        },
        data: () => ({
            name: '',
            email: '',
            createdAt: '',
            updatedAt: '',
            select: null,
            roles: [
            ],
            checkbox: null,
        }),
        created() {
            iamClient.getUser(this.$route.params.userId)
                .then(response => {
                    this.email = response.data.email;
                    this.createdAt = response.data.createdAt;
                    this.updatedAt = response.data.updatedAt;
                    this.roles = response.data.roles;
                    this.select = this.roles[0];
                })
                .catch(({response}) => {
                    console.log(response);
                })
        },
        methods: {
            submit () {
                this.$refs.observer.validate()
            },
            clear () {
                this.name = ''
                this.email = ''
                this.select = null
                this.checkbox = null
                this.$refs.observer.reset()
            },
        },
    }
</script>

<style scoped>

</style>