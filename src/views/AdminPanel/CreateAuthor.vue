<template>
  <h2>Assign <span>author</span> role to user.</h2>

  <router-link :to="{path: '/panel'}" style="text-decoration: none; color: var(--text-color); width: min-content; margin: 0 auto; background: transparent;"><div class="cancel-button">Cancel</div></router-link>

  <div class="flex-col">
    <form @submit.prevent="loadUser(username)" class="login-form">
      <label for="username" class="login-label">Username</label>
      <input id="username" name="username" type="text" v-model="username" class="login-input">
      <button class="login-button">Check</button>
    </form>

    <form @submit.prevent="createAuthor(username, fname, lname)" v-if="username !== null && available" class="login-form">
      <label for="fname" class="login-label">First name</label>
      <input id="fname" name="fname" type="text" v-model="fname" class="login-input">

      <label for="lname" class="login-label">Last name</label>
      <input id="lname" name="lname" type="text" v-model="lname" class="login-input">

      <input type="submit" name="create" value="Create author" class="login-submit">
    </form>

    <h4 v-if="message != null">{{ message }}</h4>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "CreateAuthor",
  data() {
    return {
      username: null,
      available: false,
      message: null,
      fname: '',
      lname: '',
    }
  },
  methods: {
    async loadUser(username) {
      await axios.post('/api/details.php', {
        'request': 'is_author',
        'username': username
      }).then(response => response.data).then(json => {
        if (json.success) {
          this.available = !json.author
          this.message = (!this.available) ? 'User is already author' : null
        } else {
          this.message = json.message
        }
      })
    },
    async createAuthor(username, firstname, lastname) {
      await axios.post('/api/create-author.php', {
        'username': username,
        'firstname': firstname,
        'lastname': lastname
      }).then(response => response.data).then(json => {
        if (json.success) this.message = 'Author added'
        else this.message = json.message
      })
    }
  }
}
</script>

<style scoped>

</style>