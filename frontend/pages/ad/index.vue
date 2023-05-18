<template>
  <v-row>
    <v-col cols="12">
      <v-btn to="/ad/add">
        Добавить объявление
      </v-btn>
    </v-col>
    <loading-bar v-if="loading" />
    <v-col v-for="item in items" v-else :key="item.slug" cols="3">
      <v-card :to="'/ad/'+item.slug">
        <v-card-title>{{ item.title }}</v-card-title>
        <v-card-subtitle v-if="item.user">
          {{ item.user.name }}
        </v-card-subtitle>
        <v-card-text v-if="item.images.length>0">
          <v-img :src="item.images[0].public_path" />
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12">
      <v-pagination
        v-model="page"
        :length="totalPages"
      />
    </v-col>
  </v-row>
</template>
<script>
import { defineComponent } from 'vue'
import LoadingBar from '~/components/system/loading.vue'

export default defineComponent({
  name: 'ItemsIndex',
  components: { LoadingBar },
  data () {
    return {
      loading: false,
      items: [],
      perPage: 10,
      page: parseInt(this.$route.query.page) || 1,
      totalPages: 1
    }
  },
  watch: {
    page () {
      this.$router.replace({ query: { ...this.$route.query, page: this.page } })
      this.loadItems()
    }
  },
  mounted () {
    this.loadItems()
  },
  methods: {
    async loadItems () {
      this.loading = true

      await this.$axios.get('/api/catalogItem', {
        params: {
          page: this.page,
          paginate: this.perPage
        }
      }).then(response => response.data.result)
        .then((result) => {
          this.items = result.items
          if (result.total_pages) {
            this.totalPages = result.total_pages
          }
        })
        .catch(error => error.data)

      this.loading = false
    }
  }
})
</script>

<style scoped>

</style>
