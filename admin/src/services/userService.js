import User from '../models/user';
import Token from '../models/token';
import jwt_decode from 'jwt-decode';

class UserService {
    createUserFromLoginResponse(data) {
        const decodedJWT = jwt_decode(data.token);
        const token = new Token(data.token, data.refresh_token, decodedJWT.expiresAt);
        return new User(decodedJWT.id, decodedJWT.email, token);
    }
}

export default new UserService();