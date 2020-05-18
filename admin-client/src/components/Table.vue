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
      <span>{{ item.createdAt | moment("YYYY-MM-DD hh:mm:ss") }}</span>
    </template>
    <template v-slot:item.deletedAt="{ item }">
      <span>{{ item.deletedAt | moment("YYYY-MM-DD hh:mm:ss") }}</span>
    </template>
  </v-data-table>
</template>

<script>
  import iamClient from "../services/iamClient";
  import { mapState } from 'vuex'

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
        { text: 'Deleted at', value: 'deletedAt' },
      ],
      desserts: [],
    }),
    computed: {
      ...mapState('account', ['loggingIn', 'user']),
    },
    created() {
      iamClient.getUsers(this.user.token)
              .then(response => {
                this.desserts = response.data;
              })
              .catch(({response}) => {
                console.log(response);
              })
    },
  }
</script>
