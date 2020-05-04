import User from '../models/user';
import Token from '../models/token';
import jwt_decode from 'jwt-decode';

class UserService {
    createUserFromLoginResponse(data) {
        const decodedJWT = jwt_decode(data.token);
        const token = new Token(data.token, data.refresh_token, decodedJWT.expiresAt);
        return new User(decodedJWT.id, decodedJWT.email, token);
    }

    createUserFromLocalStorage(data) {
        const token = new Token(data.token.token, data.token.refresh_token, data.token.expiresAt);
        return new User(data.id, data.email, token);
    }
}

export default new UserService();