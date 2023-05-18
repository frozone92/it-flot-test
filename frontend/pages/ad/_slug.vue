<template>
  <v-row>
    <loading-bar v-if="loading" />
    <v-col v-else cols="6">
      <v-card v-if="item">
        <v-card-title>{{ item.title }}</v-card-title>
        <v-card-subtitle v-if="item.user">
          {{ item.user.name }}
        </v-card-subtitle>
        <v-card-text v-if="item.images.length>0">
          <v-row>
            <v-col v-for="image in item.images" :key="image" cols="4">
              <v-img :src="image.public_path" />
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import { defineComponent } from 'vue'
import LoadingBar from '~/components/system/loading.vue'

export default defineComponent({
  name: 'ItemPage',
  components: { LoadingBar },
  data () {
    return {
      loading: false,
      item: null
    }
  },
  computed: {
    itemSlug () {
      return this.$route.params.slug
    }
  },
  mounted () {
    this.loadItem()
  },
  methods: {
    async loadItem () {
      this.loading = true
      this.item = await this.$axios.get(`/api/catalogItem/${this.itemSlug}`)
        .then(response => response.data.result.item)
        .catch(error => error.data)
      this.loading = false
    }
  }
})
</script>

<style scoped>

</style>
