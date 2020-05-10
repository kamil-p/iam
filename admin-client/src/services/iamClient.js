import axios from '../plugins/axios';
import Token from "../models/token";
import store from '../plugins/store';
import User from "../models/user";

function validateToken(userModel) {
    if (!(userModel instanceof User)) {
        throw 'Given argument is not instance of token';
    }

    if (!(userModel.token instanceof Token)) {
        throw 'Given argument is not instance of token';
    }
}

function getHeaders() {
    const userModel = store.state.account.user;
    validateToken(userModel);
    return { headers: {Authorization: `Bearer ${userModel.token.token}`, Accept: 'application/json'}};
}

class IamClient {
    authenticate(email, password) {
        return axios.post('authentication', { email, password });
    }

    getUsers() {
        return axios.get('users', getHeaders());
    }

    getUser(id) {
        return axios.get('users/' + id, getHeaders());
    }

    patchUser(id, email) {
        return axios.put('users/' + id, { email }, getHeaders());
    }
}

export default new IamClient();