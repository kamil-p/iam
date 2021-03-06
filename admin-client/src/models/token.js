export default class Token {
    constructor(token, refreshToken, expiresAt) {
        this.token = token;
        this.expiresAt = expiresAt;
        this.refreshToken = refreshToken;
    }

    expired() {
        return this.expiresAt < (Date.now()/1000);
    }
}