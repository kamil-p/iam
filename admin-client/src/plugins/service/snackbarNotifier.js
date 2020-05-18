import store from '../store'

class SnackbarNotifier {
    notify(message, color = 'primary') {
        store.commit('snackbar/show', { message, color});
    }
}

export default new SnackbarNotifier();