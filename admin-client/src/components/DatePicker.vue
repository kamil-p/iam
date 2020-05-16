<template>
            <v-menu
                    ref="menu1"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    max-width="290px"
                    min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                            v-bind:value="formattedDate"
                            v-on:input="$emit('input', $event.target.value)"
                            :label="label"
                            persistent-hint
                            readonly
                            solo
                            v-on="on"
                    ></v-text-field>
                </template>
                <v-date-picker v-if="value" v-model="value" no-title @input="menu1 = false" readonly></v-date-picker>
            </v-menu>
</template>

<script>
    import moment from 'moment';

    export default {
        name: 'DatePicker',
        props: {
            label: {
                type: String
            },
            date: {
                type: [Object, String]
            }
        },
        data() {
            return {}
        },
        computed: {
            value: function() {
                if (moment.isMoment(this.date)) {
                    return this.date.toDate().toISOString().substr(0, 10);
                }

                return false;
            },
            formattedDate: function() {
                if (moment.isMoment(this.date)) {
                    return this.date.format('llll')
                }

                return 'N/A';
            },
        },
    }
</script>

<style scoped>

</style>