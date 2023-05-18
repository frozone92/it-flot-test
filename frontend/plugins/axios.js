export default function ({ $axios, store }) {
  $axios.onError((error) => {
    if (error.response) {
      if (error.response.status === 401) {
        store.dispatch('snackbar/showSnackbar', {
          color: 'error',
          text: 'Авторизация истекла. Повторите вход',
        })
      } else if (error.response.data.message) {
        store.dispatch('snackbar/showSnackbar', {
          color: 'error',
          text: error.response.data.message,
        })
      }
    }
  })
  $axios.onResponse((response) => {
    if (response.data.message) {
      if (response.data.success) {
        store.dispatch('snackbar/showSnackbar', {
          color: 'success',
          text: response.data.message,
        })
      }
    }
  })
}
