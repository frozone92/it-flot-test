<template>
  <v-snackbar
    v-model="showSnackbar"
    :timeout="snackbar.timeout"
    light
    transition="slide-y-reverse-transition"
  >
    {{ snackbar.text }}

    <template #action="{ attrs }">
      <v-btn
        :color="snackbar.color || 'green'"
        text
        v-bind="attrs"
        @click="closeSnackbar"
      >
        Закрыть
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script>
export default {
  name: 'SnackBar',
  computed: {
    snackbar () {
      return this.$store.getters['snackbar/getSnackbar']
    },
    showSnackbar: {
      get () {
        return this.snackbar.visible
      },
      set (value) {
        if (value === false) {
          return this.$store.dispatch('snackbar/closeSnackbar')
        }
      }
    }
  },
  methods: {
    closeSnackbar () {
      this.$store.dispatch('snackbar/closeSnackbar')
    }
  }
}
</script>

<style scoped>

</style>
