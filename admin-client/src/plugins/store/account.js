import userService from '../../services/userService';
import router from '../router';
import iamClient from "../../services/iamClient";

let user = JSON.parse(localStorage.getItem('user'));
if (user !== null) {
    user = userService.createUserFromLocalStorage(user);
}
const state = { user, loggingIn: false };

const actions = {
    login({ commit }, { email, password }) {
        commit('userLoggingIn', true);
        iamClient.authenticate(email, password)
            .then(response => {
                commit('userLoggedIn', userService.createUserFromLoginResponse(response.data));
                commit('userLoggingIn', false);
                router.push({ name: 'panel_table' });
            })
            .catch(({response}) => {
                commit('userLoggingIn', false);
                console.log(response);
            });
    }
}

const mutations = {
    userLoggingIn(state, loggingIn) {
      state.loggingIn = loggingIn;
    },
    userLoggedIn(state, user) {
        state.user = user;
        localStorage.setItem('user', JSON.stringify(user));
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
};

