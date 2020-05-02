<template>
  <v-container>
    <template>
      <v-data-table
              :headers="headers"
              :items="desserts"
              :items-per-page="10"
              class="elevation-1"
      >
        <template v-slot:item.id="{ item }">
          <span><router-link :to="{ name: 'panel_user', params: { userId: item.id }}">{{ item.id }}</router-link></span>
        </template>
        <template v-slot:item.createdAt="{ item }">
          <span>{{ new Date(item.createdAt).toLocaleString() }}</span>
        </template>
        <template v-slot:item.updatedAt="{ item }">
          <span>{{ new Date(item.updatedAt).toLocaleString() }}</span>
        </template>
      </v-data-table>
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
        { text: 'Updated at', value: 'updatedAt' },
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
