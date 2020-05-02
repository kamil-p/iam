<template>
    <h1>kamil</h1>
</template>

<script>
    //import { required, email, max } from 'vee-validate/dist/rules'
    //import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'

    //setInteractionMode('eager')

    /*extend('required', {
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
    })*/

    export default {
        name: 'UserForm',
        // components: {
        //     ValidationProvider,
        //     ValidationObserver,
        // },
        data: () => ({
            name: '',
            email: '',
            select: null,
            items: [
                'Item 1',
                'Item 2',
                'Item 3',
                'Item 4',
            ],
            checkbox: null,
        }),

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