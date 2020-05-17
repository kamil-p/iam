<template>
    <ValidationObserver ref="observer" >
        <Snackbar/>
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
            ></v-select>
            <DatePicker label="Created at" :date="createdAt"></DatePicker>
            <DatePicker label="Deleted at" :date="deletedAt"></DatePicker>

            <v-btn class="mr-4" @click="submit">submit</v-btn>
            <v-btn v-if="!deletedAt" class="mr-4" color="error" @click="remove">delete</v-btn>
            <v-btn v-if="deletedAt" class="mr-4" color="primary" @click="undelete">undelete</v-btn>

        </form>
    </ValidationObserver>
</template>

<script>
    import { required, email, max } from 'vee-validate/dist/rules'
    import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'
    import iamClient from "../services/iamClient";
    import Snackbar from "./Snackbar";
    import moment from 'moment';
    import DatePicker from "./DatePicker";

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
            DatePicker,
            ValidationProvider,
            ValidationObserver,
            Snackbar
        },
        data: () => ({
            name: '',
            email: '',
            createdAt: '',
            deletedAt: '',
            select: null,
            roles: [
            ],
            checkbox: null,
        }),
        created() {
            iamClient.getUser(this.$route.params.userId)
                .then(response => {
                    this.email = response.data.email;
                    this.createdAt = moment(response.data.createdAt);
                    this.deletedAt = response.data.deletedAt ? moment(response.data.deletedAt) : null;
                    this.roles = response.data.roles;
                    this.select = this.roles[0];
                })
                .catch(({response}) => {
                    console.log(response);
                })
        },
        methods: {
            submit() {
                this.$refs.observer.validate()
                iamClient.patchUser(this.$route.params.userId, this.email)
                    .catch(({response}) => {
                        console.log(response);
                    });
            },
            undelete() {
                iamClient.undeleteUser(this.$route.params.userId)
                    .catch(({response}) => {
                        console.log(response);
                    });
            },
            remove() {
                iamClient.deleteUser(this.$route.params.userId)
                    .catch(({response}) => {
                        console.log(response);
                    });
            },
            clear() {
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