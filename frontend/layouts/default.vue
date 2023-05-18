<template>
  <v-app>
    <v-navigation-drawer
      app
      expand-on-hover
      :mini-variant.sync="mini"
      permanent
    >
      <v-list-item class="px-2">
        <v-list-item-avatar>
          <v-icon>
            mdi-account-circle
          </v-icon>
        </v-list-item-avatar>

        <v-list-item-title>
          {{ user ? user.name : 'Test Project' }}
        </v-list-item-title>
      </v-list-item>

      <v-divider />

      <v-list dense>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
          :to="item.to"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <template #append>
        <v-divider />
        <v-list class="pt-0" dense>
          <v-list-item
            link
            @click="logOut"
          >
            <v-list-item-icon>
              <v-icon>mdi-logout</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Выйти</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </template>
    </v-navigation-drawer>
    <v-main>
      <v-container fluid>
        <Nuxt />
      </v-container>
    </v-main>
    <v-footer
      absolute
      app
    >
      <span>Test {{ new Date().getFullYear() }}</span>
    </v-footer>
    <system-snack-bar />
  </v-app>
</template>

<script>
export default {
  name: 'DefaultLayout',
  data () {
    return {
      title: 'It-Flot Test project',
      mini: true,
      items: [
        {
          icon: 'mdi-view-list',
          title: 'Объявления',
          to: '/ad'
        }
      ]
    }
  },
  computed: {
    user () {
      return this.$auth.user
    }
  },
  methods: {
    logOut () {
      this.$auth.logout()
    }
  }
}
</script>
