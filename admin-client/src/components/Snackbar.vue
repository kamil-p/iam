<template>
    <v-card>
        <v-snackbar
                v-model="show"
                :bottom="y === 'bottom'"
                :color="color"
                :left="x === 'left'"
                :multi-line="mode === 'multi-line'"
                :right="x === 'right'"
                :timeout="timeout"
                :top="y === 'top'"
                :vertical="mode === 'vertical'"
        >
            {{ message }}
            <v-btn
                    dark
                    text
                    @click="show = false"
            >
                Close
            </v-btn>
        </v-snackbar>
    </v-card>
</template>


<script>
    export default {
        name: 'Snackbar',
        data () {
            return {
                mode: '',
                timeout: 1000,
                x: null,
                y: 'top',
                show: false,
                message: '',
                color: '',
            }
        },
        methods: {
            close() {
                this.show = false;
            }
        },
        created() {
            this.$store.subscribe((mutation, state) => {
                if (mutation.type === 'snackbar/show') {
                    this.message = state.snackbar.message;
                    this.color = state.snackbar.color;
                    this.show = true;
                }
            })
        }
    }
</script>

<style scoped>

</style>