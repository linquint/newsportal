<template>
  <div class="view">
    <section class="list" style="overflow: hidden" :style="action && windowWidth < 721 ? 'display: none' : ''">
      <span v-if="!userDataLoaded">Loading... Please wait...</span>

      <template v-else-if="user.loggedIn">
        <router-link v-if="user.isAdmin" :to="{name: 'Panel'}" style="text-decoration: none; color: #222;">
          <div class="account-button">
            <img src="/src/assets/icons/admin.png" alt="Admin">
            <span>Admin panel</span>
          </div>
        </router-link>

        <router-link v-if="user.isAuthor" :to="{name: 'AuthorPanel'}" style="text-decoration: none; color: #222;">
          <div class="account-button">
            <img src="/src/assets/icons/feather.png" alt="Author">
            <span>Author panel</span>
          </div>
        </router-link>

        <router-link to="/" style="text-decoration: none; color: #222; width: min-content;">
          <div class="account-button">
            <img src="/src/assets/icons/bookmark-full.png" alt="Saved articles">
            <span>My saved articles</span>
          </div>
        </router-link>

        <router-link to="/" style="text-decoration: none; color: #222; width: min-content;">
          <div class="account-button">
            <img src="/src/assets/icons/like-full.png" alt="Rating">
            <span>My rated articles</span>
          </div>
        </router-link>

        <router-link to="/account/edit" style="text-decoration: none; color: #222; width: min-content;">
          <div class="account-button">Edit profile</div>
        </router-link>

        <a href="#" style="text-decoration: none; color: #222; width: min-content;">
          <div @click="logOut()" class="account-logout account-button">Log out</div>
        </a>
      </template>

      <template v-else>
        <h2>You are not logged in</h2>
        <router-link :to="{name: 'Login'}" style="text-decoration: none; color: #222;" @click="action = true"><div class="account-button">Log In</div></router-link>
        <router-link :to="{name: 'Register'}" style="text-decoration: none; color: #222;" @click="action = true"><div class="account-button">Register</div></router-link>
      </template>
    </section>

    <section class="reader" style="overflow: hidden" v-if="(action && windowWidth < 721) || (windowWidth > 720)">
      <div v-if="!action" style="display: flex; flex-direction: column; height: calc(100% - 60px); justify-content: center;">
        <span style="font-size: 1.5em; font-weight: bold;">Select action</span>
        <span>Select an action to perform from the left side</span>
      </div>

      <router-view v-else />
    </section>
  </div>


  <!-- <div v-if="!userDataLoaded">
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
  </div> -->
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
      action: false,
      windowWidth: window.innerWidth,
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
    },
    getWidth() {
      return window.innerWidth;
    },
    onResize() {
      this.windowWidth = window.innerWidth;
    },
  },
  mounted() {
    this.$nextTick(() => {
      window.addEventListener("resize", this.onResize);
    });
    this.action = this.$route.path.includes('account/')
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.onResize);
  },
  updated() {
    this.action = this.$route.path.includes('account/')
  }
}
</script>

<style scoped>
</style>