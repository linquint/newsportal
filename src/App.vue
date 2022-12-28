<template>
  <div class="container">
    <div class="top-bar">
      <h1>{{ $route.meta.title.replace(' - 16min', '') ?? "16min" }}</h1>

      <button type="button" class="nav-button" v-if="areLightsOn" @click="changeTheme(false)" style="width: 52px; height: 52px; margin: 0 2em 0 auto;">
        <img src="./assets/icons/lights-off.png" alt="Lights off" class="nav-icon">
      </button>

      <button type="button" class="nav-button" v-else @click="changeTheme(true)" style="width: 52px; height: 52px; margin: 0 2em 0 auto;">
        <img src="./assets/icons/lights-on.png" alt="Lights on" class="nav-icon">
      </button>
    </div>

    <nav>
      <router-link :to="{name: 'Home'}" style="text-decoration: none; color: #222; width: calc(80px - 1em);">
        <div class="nav-button">
          <img src="/src/assets/icons/news.png" alt="News" class="nav-icon">
          <span class="navigation-text">News</span>
        </div>
      </router-link>

      <router-link :to="{name: 'Search'}" style="text-decoration: none; color: #222; width: calc(80px - 1em);">
        <div class="nav-button">
          <img src="/src/assets/icons/search.png" alt="Search" class="nav-icon">
          <span class="navigation-text">Search</span>
        </div>
      </router-link>

      <router-link :to="{name: 'Popular'}" style="text-decoration: none; color: #222; width: calc(80px - 1em);">
        <div class="nav-button">
          <img src="/src/assets/icons/fire.png" alt="Trending" class="nav-icon">
          <span class="navigation-text">Trending</span>
        </div>
      </router-link>

      <router-link :to="{name: 'Account'}" style="text-decoration: none; color: #222; width: calc(80px - 1em);">
        <div class="nav-button">
          <img src="/src/assets/icons/user.png" alt="User" class="nav-icon">
          <span class="navigation-text">Account</span>
        </div>
      </router-link>

    </nav>

    <main>
      <router-view />
    </main>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "App",
  data() {
    return {
      topCategories: null,
      topAuthors: null,
      areLightsOn: true,
    }
  },
  computed: {
    width() {
      return window.innerWidth
    }
  },
  methods: {
    changeTheme(lights) {
      if (lights == null) {
        this.$cookies.set('lights', true, 60 * 60 * 24 * 90)
        document.body.classList.add('lights-on')
        return
      }

      if (lights) {
        document.body.classList.remove('lights-off')
        document.body.classList.add('lights-on')
      } else {
        document.body.classList.remove('lights-on')
        document.body.classList.add('lights-off')
      }
      this.areLightsOn = lights
      this.$cookies.set('lights', lights, 60 * 60 * 24 * 90)
    }
  },
  watch: {
    $route: {
      immediate: true,
      handler(to, from) {
        document.title = to.meta.title || '16min';
      }
    },
  },
  async created() {
    console.log("lights on: " + this.$cookies.get('lights'))
    this.changeTheme(this.$cookies.get('lights'))

    await axios.post('/api/getTopFooter.php').then(response => response.data).then(json => {
      if (json.success) {
        this.topCategories = json.topCategories
        this.topAuthors = json.topAuthors
      }
    })
  },
}
</script>

<style>
#app {
  height: 100%;
}

.flex-row {
  display: flex;
  flex-direction: row;
}

.top-bar {
  position: fixed;
  top: 0%;
  width: 100%;
  z-index: 9999;
  background: var(--nav-background);
  padding: 0 1em;
  border-bottom: var(--border-thin);
  display: flex;
  flex-direction: row;
}

.top-bar h1 {
  font-size: 1.25em;
  text-align: left;
  margin: 16px 0;
  width: fit-content;
}

.top-bar button {
  align-self: center;
}

.top-bar button img {
  width: 32px;
  height: 32px;
  margin: auto;
}

.brand {
  margin: 0 1.5rem 0 1rem;
  font-size: 30px;
}

.footer {
  width: 85%;
  padding: 32px;
  display: flex;
  flex-direction: row;
  background: #00494A;
  justify-content: space-evenly;
  margin: 32px auto 0;
  border-radius: 32px 32px 0 0;
}

.footer-title {
  font-size: 18px;
  font-weight: bold;
  color: #A0CA97;
}

.footer-url {
  text-decoration: none;
  color: #FC9F8F;
  font-size: 16px;
  transition: all .2s;
}

.footer-url:hover {
  color: #D15D4C;
}
</style>
