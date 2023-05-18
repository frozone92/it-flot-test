export default {
  state () {
    return {
      snackbar: {
        visible: false,
        text: null,
        timeout: 2000,
        multiline: false,
        color: null
      }
    }
  },
  getters: {
    getSnackbar: (state) => {
      return state.snackbar
    }
  },
  mutations: {
    showSnackbar (state, payload) {
      state.snackbar.text = payload.text
      state.snackbar.color = payload.color
      state.snackbar.multiline = payload.text.length > 50

      if (payload.multiline) {
        state.snackbar.multiline = payload.multiline
      }

      if (payload.timeout) {
        state.snackbar.timeout = payload.timeout
      }

      state.snackbar.visible = true
    },
    closeSnackbar (state) {
      state.snackbar.visible = false
      state.snackbar.multiline = false
      state.snackbar.timeout = 2000
      state.snackbar.text = null
      state.snackbar.color = null
    }
  },
  actions: {
    showSnackbar ({ commit }, payload) {
      commit('showSnackbar', payload)
    },
    closeSnackbar ({ commit }) {
      commit('closeSnackbar')
    }
  }
}
