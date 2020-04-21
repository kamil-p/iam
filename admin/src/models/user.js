export default class User {
    constructor(token, refreshToken, email) {
        this.token = token;
        this.refreshToken = refreshToken;
        this.email = email;
    }
}