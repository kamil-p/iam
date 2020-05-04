import axios from '../plugins/axios';
import Token from "../models/token";

function valdateToken(token) {
    if (!(token instanceof Token)) {
        throw 'Given argument is not instance of token';
    }
}

class IamClient {
    authenticate(email, password) {
        return axios.post('authentication', { email, password });
    }

    getUsers(token) {
        valdateToken(token);
        return axios.get('users', { headers: {Authorization: `Bearer ${token.token}`, Accept: 'application/json'}});
    }
}

export default new IamClient();