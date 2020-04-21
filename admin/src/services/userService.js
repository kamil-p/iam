import User from '../models/user';

class UserService {
    createUserFromLoginResponse(data) {
        const user = new User(data.token, data.refresh_token);

        return user;
    }
}

export default new UserService();