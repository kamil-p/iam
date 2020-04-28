import axios from '../axios';
import userService from '../../services/userService';
import router from '../router';

const user = JSON.parse(localStorage.getItem('user'));
const state = { user, loggingIn: false };

const actions = {
    login({ commit }, { email, password }) {
        commit('userLoggingIn', true);
        axios.post('authentication', { email, password })
            .then(response => {
                commit('userLoggedIn', userService.createUserFromLoginResponse(response.data));
                commit('userLoggingIn', false);
                router.push('panel');
            })
            .catch(({response}) => {
                commit('userLoggingIn', false);
                console.log(response);
            })
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

