const state = { show: false, color: 'primary', message: '' };

const actions = {
    showSnackbar({ commit }, { color, message }) {
        commit('show', { color, message });
    },
    hideSnackbar({ commit }) {
        commit('hide');
    }
}

const mutations = {
    show(state, { color, message}) {
      state.show = true;
      state.color = color;
      state.message = message;
    },
    hide(state) {
        state.show = false;
    }
}


export default {
    namespaced: true,
    state,
    actions,
    mutations,
};
