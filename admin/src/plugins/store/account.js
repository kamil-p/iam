import axios from "axios";
import userService from '../../services/userService';

const user = JSON.parse(localStorage.getItem('user'));
const state = user;

const actions = {
    login({ commit }, { email, password }) {
        console.log({ email, password });
        axios.post('http://localhost/api/authentication', { email, password })
            .then(response => {
                commit('userLoggedIn', userService.createUserFromLoginResponse(response.data));
            })
            .catch(({response}) => { console.log(response); })
    }
}

const mutations = {
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

