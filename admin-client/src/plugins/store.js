import Vue from 'vue'
import Vuex from 'vuex'

import account from './store/account';
import snackbar from "./store/snackbar";

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        account,
        snackbar
    }
});