<template>
  <div class="view">
    <h1>Log In</h1>
    <form class="login-form" @submit.prevent="login()">
      <label for="username" class="login-label">Username</label>
      <input type="text" id="username" name="username" class="login-input" v-model="username">

      <label for="password" class="login-label">Password</label>
      <input type="password" id="password" name="password" class="login-input" v-model="password">

      <input type="submit" class="login-submit" name="login" value="Log in">

      <p style="color: red; font-weight: bold;" v-html="errors"></p>
    </form>
  </div>
</template>

<script>

import axios from "axios";

export default {
  name: "Login",
  data () {
    return {
      username: '',
      password: '',
      errors: '',
    }
  },
  methods: {
    async login() {
      await axios.post('/api/login.php', {
        username: this.username,
        password: this.password
      }).then(response => {
        return response.data
      }).then(async json => {
        if (json.success) {
          localStorage.setItem('loggedIn', "true")
          localStorage.setItem('user', json.username)
          await this.$router.push({name: 'Home'})
        } else {
          this.errors = json.message
        }
      })
    }
  }
}
</script>

<style scoped>

</style>