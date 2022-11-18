<template>
  <div v-if="!userDataLoaded">
    <h1>Getting user data...</h1>
  </div>

  <div class="view">
    <div v-if="user.loggedIn" style="width: 100%">
      <div style="margin: 0 0 0 auto; width: min-content;">
        <p style="text-align: right; font-size: 16px;">Hello <span style="font-weight: bold">{{ user.user }}</span></p>
        <div class="flex-row">
          <router-link to="/account/edit" style="text-decoration: none; color: #222; width: min-content;"><div class="login-button">Edit profile</div></router-link>
          <a href="#" style="text-decoration: none; color: #222; width: min-content; margin-left: 32px;"><div @click="logOut()" class="cancel-button">Log out</div></a>
        </div>
      </div>

      <div class="flex-row" style="margin: 0 auto; flex-wrap: wrap; justify-content: space-evenly;">
        <router-link :to="{name: 'Home'}" style="text-decoration: none; color: #222;">
          <div class="nav-button">
            <img src="/src/assets/icons/bookmark-full.png" alt="Saved articles" class="nav-icon">
            <span class="navigation-text">My saved articles</span>
          </div>
        </router-link>

        <router-link :to="{name: 'Home'}" style="text-decoration: none; color: #222;">
          <div class="nav-button">
            <img src="/src/assets/icons/like-full.png" alt="Rating" class="nav-icon">
            <span class="navigation-text">My rated articles</span>
          </div>
        </router-link>

        <router-link v-if="user.isAuthor" :to="{name: 'AuthorPanel'}" style="text-decoration: none; color: #222;">
          <div class="nav-button">
            <img src="/src/assets/icons/feather.png" alt="Author" class="nav-icon">
            <span class="navigation-text">Author panel</span>
          </div>
        </router-link>

        <router-link v-if="user.isAdmin" :to="{name: 'Panel'}" style="text-decoration: none; color: #222;">
          <div class="nav-button">
            <img src="/src/assets/icons/admin.png" alt="Admin" class="nav-icon">
            <span class="navigation-text">Admin panel</span>
          </div>
        </router-link>
      </div>

      <router-view></router-view>
    </div>

    <div v-else style="width: fit-content; margin: 64px auto 0 auto">
      <h2>You are not logged in</h2>
      <router-link :to="{name: 'Login'}" style="text-decoration: none; color: #222;"><div class="login-button">Log In</div></router-link>
      <p>or</p>
      <router-link :to="{name: 'Register'}" style="text-decoration: none; color: #222;"><div class="login-button">Register</div></router-link>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Account",
  data() {
    return {
      user: {
        loggedIn: false
      },
      userDataLoaded: false,
    }
  },
  async created() {
    await axios.post('/api/isLoggedIn.php').then(response => response.data).then(json => {
      this.loggedIn = json['loggedIn'];
    })

    if (!this.userDataLoaded) await this.getUser()
  },
  methods: {
    async logOut() {
      await axios.post('/api/logout.php').then(async () => {
        localStorage.setItem("loggedIn", "false")
        await this.$router.push({name: 'Home'})
      })
    },
    async getUser() {
      await axios.post('/api/details.php', { 'request': 'get_details' }).then(response => response.data).then(json => {
        if (json['loggedIn']) this.user = json
        else this.user.loggedIn = false
        this.userDataLoaded = true
      })
    }
  },
}
</script>

<style scoped>
</style>