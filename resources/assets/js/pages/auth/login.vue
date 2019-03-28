<template>
  <v-app id="login" class="primary">
    <div v-if="busy" id="loading"><img width="100px" src="/img/static/loading.gif"/></div>
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4 lg4>
            <v-card class="elevation-1 pa-3">
              <v-card-text>
                <div class="layout column align-center">
                  <img src="/img/static/bakou.png" alt="Bakou System" width="220">
                  <h2 class="flex my-4 primary--text">Credential Login</h2>
                </div>                
                <v-form>
                  <email-input
                  :form="form"
                  :label="$t('email')"
                  :v-errors="errors"
                  :value.sync="form.email"
                  name="email"
                  v-validate="'required|email'"
                ></email-input>


                <password-input
                  :v-errors="errors"
                  :form="form"
                  :value.sync="form.password"
                  v-validate="'required|min:8'"
                ></password-input>


                <v-checkbox
                  :label="$t('remember_me')"
                  color="primary"
                  type="checkbox"
                  v-model="remember"
                  value="true"
                ></v-checkbox>
                  <!--<v-text-field append-icon="person" name="email" label="email" type="email"></v-text-field>
                  <v-text-field append-icon="lock" name="password" label="Password" id="password" type="password"></v-text-field>-->
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-btn icon>
                  <v-icon color="blue">fa fa-facebook-square fa-lg</v-icon>
                </v-btn>
                <v-btn icon>
                  <v-icon color="red">fa fa-google fa-lg</v-icon>
                </v-btn>
                <v-btn icon>
                  <v-icon color="light-blue">fa fa-twitter fa-lg</v-icon>
                </v-btn>
                <v-spacer></v-spacer>
                <!--<v-btn block color="primary" @click="login" :loading="loading">Login</v-btn>-->
                <v-btn block color="primary" @click="login" :loading="loading">Login</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
  
  <!--<v-layout row>

  

    <v-flex xs12 sm8 offset-sm2 lg4 offset-lg4>
      <v-card>
        <progress-bar :show="busy"></progress-bar>
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <v-card-title primary-title>
            <h3 class="headline mb-0">{{ $t('login') }}</h3>
          </v-card-title>
          <v-card-text>

            <email-input
              :form="form"
              :label="$t('email')"
              :v-errors="errors"
              :value.sync="form.email"
              name="email"prepend="person_outline"
              v-validate="'required|email'"
            ></email-input>


            <password-input
              :v-errors="errors"
              :form="form"
              :value.sync="form.password"
              prepend="lock_outline"
              v-validate="'required|min:8'"
            ></password-input>


            <v-checkbox
              :label="$t('remember_me')"
              color="primary"
              type="checkbox"
              v-model="remember"
              value="true"
            ></v-checkbox>

            <submit-button :block="true" :form="form" :label="$t('login')"></submit-button>

          </v-card-text>
          <v-card-actions>
            <router-link :to="{ name: 'register' }">
              {{ $t('register') }}
            </router-link>
            <v-spacer></v-spacer>
            <router-link :to="{ name: 'password.request' }">
              {{ $t('forgot_password') }}
            </router-link>
          </v-card-actions>
        </form>
      </v-card>
    </v-flex>
  </v-layout>-->
</template>
<style>
    #loading{position:absolute;top:30%;left:46%;right:40%;z-index:100}
</style>
<script>
import Form from 'vform'

export default {
  name: 'login-view',
  metaInfo () {
    return { title: this.$t('login') }
  },
  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    model: {
      username: 'admin@isockde.com',
      password: 'password'
    },
    loading: false,
    eye: true,
    remember: false,
    busy: false
  }),

  methods: {
    async login () {
      if (await this.formHasErrors()) return
      this.busy = true

      // Submit the form.
      const { data } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('fetchUser')
      this.busy = false

      // Redirect home.
      this.$router.push({ name: 'Dashboard' })
      // window.location.href=""
    }
  }
}
</script>
