<template>
  <v-content>
    <v-container fluid fill-height>
      <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
          <v-card class="elevation-12">
            <v-toolbar color="primary" dark flat>
              <v-toolbar-title>Login</v-toolbar-title>
            </v-toolbar>
            <v-card-text>
              <v-form>
                <v-text-field
                  label="Login"
                  name="email"
                  prepend-icon="person"
                  type="text"
                  v-model="formData.email"
                  class="form-action"
                ></v-text-field>

                <v-text-field
                  id="password"
                  label="Password"
                  name="password"
                  prepend-icon="lock"
                  type="password"
                  v-model="formData.password"
                  class="form-action"
                ></v-text-field>
              </v-form>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="primary"
                :loading="isLoading"
                @click.prevent="doLogin"
                >Login</v-btn
              >
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-content>
</template>

<script>
import wait from '~/helpers/wait'

export default {
  name: 'Login',
  layout: 'bare',
  data() {
    return {
      isLoading: false,
      formData: {
        email: '',
        password: ''
      }
    }
  },
  computed: {
    next() {
      return 'next' in this.$route.query ? this.$route.query.next : '/'
    },
    route() {
      return this.$nuxt
    }
  },
  methods: {
    async doLogin() {
      this.isLoading = true
      await wait(5000)
      this.isLoading = false
      this.$router.replace(this.next)
    }
  }
}
</script>

<style lang="scss">
.x-row {
  height: 100%;
}
</style>
