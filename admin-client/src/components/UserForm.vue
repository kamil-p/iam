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

            <div v-if="email">
                <v-btn class="mr-4" @click="submit" :loading="loading">submit</v-btn>
                <v-btn v-if="!deletedAt" class="mr-4" color="error" @click="remove" :loading="loading">delete</v-btn>
                <v-btn v-if="deletedAt" class="mr-4" color="primary" @click="undelete" :loading="loading">undelete</v-btn>
            </div>

        </form>
    </ValidationObserver>
</template>

<script>
    import { required, email, max } from 'vee-validate/dist/rules';
    import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate';
    import iamClient from "../services/iamClient";
    import Snackbar from "./Snackbar";
    import moment from 'moment';
    import DatePicker from "./DatePicker";
    import snackbarNotifier from "../plugins/service/snackbarNotifier";


    function loadUser(userId, vm) {
        iamClient.getUser(userId)
            .then(response => {
                setupUserData(response, vm);
                toggleLoading(vm);
            })
            .catch(response => {
                console.log(response);
            });
    }

    function setupUserData(response, vm) {
        vm.email = response.data.email;
        vm.createdAt = moment(response.data.createdAt);
        vm.deletedAt = response.data.deletedAt ? moment(response.data.deletedAt) : null;
        vm.roles = response.data.roles;
        vm.select = vm.roles[0];
    }

    function toggleLoading(vm) {
        vm.loading = !vm.loading;
    }

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
            loading: false,
        }),
        created() {
            toggleLoading(this);
            loadUser(this.$route.params.userId, this);
        },
        methods: {
            submit() {
                this.$refs.observer.validate()
                toggleLoading(this);
                iamClient.patchUser(this.$route.params.userId, this.email)
                    .then(response => {
                        setupUserData(response, this);
                        toggleLoading(this);
                        snackbarNotifier.notify('User has been updated');
                    })
                    .catch(response => {
                        toggleLoading(this);
                        console.log(response);
                    });
            },
            undelete() {
                toggleLoading(this);
                iamClient.undeleteUser(this.$route.params.userId)
                    .then(response => {
                        setupUserData(response, this);
                        toggleLoading(this);
                        snackbarNotifier.notify('User has been restored');
                    })
                    .catch(response => {
                        toggleLoading(this);
                        console.log(response);
                    });
            },
            remove() {
                toggleLoading(this);
                iamClient.deleteUser(this.$route.params.userId)
                    .then(() => {
                        loadUser(this.$route.params.userId, this);
                        snackbarNotifier.notify('User has been deleted');
                    })
                    .catch(response => {
                        toggleLoading(this);
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