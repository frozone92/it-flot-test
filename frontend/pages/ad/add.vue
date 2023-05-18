<template>
  <v-row>
    <v-col cols="4">
      <v-card>
        <v-card-title>Добавить объявление</v-card-title>
        <v-card-text>
          <v-form ref="addItemForm" @submit.prevent="submitForm">
            <v-text-field v-model="formData.title" :rules="validation.required" label="Название" />
            <v-file-input v-model="formData.images" :rules="validation.required" multiple />
            <v-btn color="primary" @click="submitForm">
              Сохранить
            </v-btn>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-chip
            v-for="error in errors"
            :key="error"
            class="ma-2"
            color="red"
            text-color="white"
          >
            {{ error[0] }}
          </v-chip>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'AddItem',
  data () {
    return {
      loading: false,
      formData: {
        title: null,
        images: []
      },
      errors: [],
      validation: {
        required: [v => !!v]
      }
    }
  },
  methods: {
    async submitForm () {
      if (this.$refs.addItemForm.validate()) {
        this.loading = true
        this.errors = []

        const formData = new FormData()
        formData.append('title', this.formData.title)
        this.formData.images.forEach((image) => {
          formData.append('images[]', image)
        })

        await this.$axios.post('/api/catalogItem', formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
        )
          .then((response) => {
            if (response.data.success) {
              this.$router.push(`/ad/${response.data.result.item.slug}`)
            }
          })
          .catch((error) => {
            if (error.response.data.errors) {
              this.errors = error.response.data.errors
            } else {
              this.errors = error.response.data.message
            }
          })
        this.loading = false
      }
    }
  }
})
</script>

<style scoped>

</style>
