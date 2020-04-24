<template>
  <v-container>
    <template>
      <v-data-table
              :headers="headers"
              :items="desserts"
              :items-per-page="5"
              class="elevation-1"
      ></v-data-table>
    </template>
  </v-container>
</template>

<script>
  import axios from "../plugins/axios";

  export default {
    name: 'Table',

    data: () => ({
      headers: [
        {
          text: 'Id',
          align: 'start',
          sortable: false,
          value: 'id',
        },
        { text: 'Email', value: 'email' },
        { text: 'Created at', value: 'createdAt' },
        { text: 'Updated at', value: 'deletedAt' },
        { text: 'Deleted at', value: 'deletedAt' },
      ],
      desserts: [],
    }),
    created() {
      const user = JSON.parse(localStorage.getItem('user'));
      axios.get('users', { headers: {Authorization: `Bearer ${user.token.token}`, Accept: 'application/json'}})
              .then(response => {
                this.desserts = response.data;
              })
              .catch(({response}) => {
                console.log(response);
              })
    },
  }
</script>
