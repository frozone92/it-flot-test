<template>
  <v-col cols="12" sm="10" md="6" lg="4" xl="3">
    <v-card :loading="loading">
      <v-card-title class="justify-center">
        Logo
      </v-card-title>
      <v-card-text>
        <v-form v-model="formValid" @submit.prevent="login">
          <v-row dense justify="center" align="center">
            <v-col cols="8" xs="10" sm="7" xl="6" align="center">
              <v-text-field
                v-model="form.email"
                placeholder="Email"
                prepend-icon="mdi-at"
                :rules="[requiredRule]"
              />
              <v-text-field
                v-model="form.password"
                placeholder="Пароль"
                prepend-icon="mdi-key"
                type="password"
                :rules="[requiredRule]"
                @keyup.enter="login"
              />
              <v-btn
                class="mt-1"
                color="primary"
                :disabled="!formValid"
                @click="login"
              >
                Войти
              </v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script>
export default {
  name: 'LoginPage',
  auth: 'guest',
  layout: 'login',
  data () {
    return {
      loading: false,
      formValid: false,
      form: {
        email: '',
        password: ''
      },

      requiredRule: v => !!v
    }
  },
  methods: {
    async login () {
      this.loading = true
      await this.$axios.get(this.$auth.strategy.options.endpoints.csrf.url)
      await this.$auth.loginWith('local', {
        data: {
          email: this.form.email,
          password: this.form.password
        }
      }).catch(error => error.response)
      this.loading = false
    }
  }
}
</script>

<style scoped>

</style>
