<template>
    <v-card>
        <v-snackbar
                v-model="snackbar"
                :bottom="y === 'bottom'"
                :color="color"
                :left="x === 'left'"
                :multi-line="mode === 'multi-line'"
                :right="x === 'right'"
                :timeout="timeout"
                :top="y === 'top'"
                :vertical="mode === 'vertical'"
        >
            {{ text }}
            <v-btn
                    dark
                    text
                    @click="snackbar = false"
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
                color: 'primary',
                mode: '',
                snackbar: false,
                text: 'User updated',
                timeout: 1000,
                x: null,
                y: 'top',
            }
        },
    }
</script>

<style scoped>

</style>