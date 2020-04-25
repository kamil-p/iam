import axios from '../axios';
import userService from '../../services/userService';
import router from '../router';

const user = JSON.parse(localStorage.getItem('user'));
const state = user;

const actions = {
    login({ commit }) {
        axios.get('users', { Authorization: `Bearer ${user.token.token}` })
            .then(response => {
                commit('userLoggedIn', userService.createUserFromLoginResponse(response.data));
                router.push('panel');
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

