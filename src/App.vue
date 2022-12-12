<template>
  <div class="container">
    <nav>
      <h1 class="brand">16min</h1>

      <router-link :to="{name: 'Home'}" style="text-decoration: none; color: #222;">
        <div class="nav-button">
          <img src="/src/assets/icons/news.png" alt="News" class="nav-icon">
          <span class="navigation-text">News</span>
        </div>
      </router-link>

      <router-link :to="{name: 'Search'}" style="text-decoration: none; color: #222;">
        <div class="nav-button">
          <img src="/src/assets/icons/search.png" alt="Search" class="nav-icon">
          <span class="navigation-text">Search</span>
        </div>
      </router-link>

      <router-link :to="{name: 'Popular'}" style="text-decoration: none; color: #222;">
        <div class="nav-button">
          <img src="/src/assets/icons/fire.png" alt="Popular" class="nav-icon">
          <span class="navigation-text">Popular</span>
        </div>
      </router-link>

      <button type="button" class="nav-button" v-if="areLightsOn" @click="changeTheme(false)">
        <img src="./assets/icons/lights-off.png" alt="Lights off" class="nav-icon">
        <span class="navigation-text">Lights Off</span>
      </button>

      <button type="button" class="nav-button" v-else @click="changeTheme(true)">
        <img src="./assets/icons/lights-on.png" alt="Lights on" class="nav-icon">
        <span class="navigation-text">Lights On</span>
      </button>

      <router-link :to="{name: 'Account'}" style="text-decoration: none; color: #222; margin: 0 1rem 0 auto;">
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

  <div class="footer">
    <div class="flex-col">
      <p class="footer-title">Categories</p>
      <div class="flex-col" v-if="topCategories == null">
        <router-link to="/category/Science" style="text-decoration: none; color: #222;"><span class="footer-url">Science</span></router-link>
        <router-link to="/category/Business" style="text-decoration: none; color: #222;"><span class="footer-url">Business</span></router-link>
        <router-link to="/category/Technology" style="text-decoration: none; color: #222;"><span class="footer-url">Technology</span></router-link>
      </div>
      <div v-else class="flex-col">
        <router-link v-for="i in topCategories.length" :to="'/category/' + topCategories[i-1].title" style="text-decoration: none; color: #222;"><span class="footer-url">{{ topCategories[i-1].title }}</span></router-link>
      </div>
    </div>

    <div class="flex-col">
      <p class="footer-title">Top authors</p>
      <div class="flex-col" v-if="topAuthors == null">
        <router-link to="/category/Science" style="text-decoration: none; color: #222;"><span class="footer-url">Science</span></router-link>
        <router-link to="/category/Business" style="text-decoration: none; color: #222;"><span class="footer-url">Business</span></router-link>
        <router-link to="/category/Technology" style="text-decoration: none; color: #222;"><span class="footer-url">Technology</span></router-link>
      </div>
      <div v-else class="flex-col">
        <router-link v-for="i in topAuthors.length" :to="'/author/' + topAuthors[i-1].name" style="text-decoration: none; color: #222;"><span class="footer-url">{{ topAuthors[i-1].name }}</span></router-link>
      </div>
    </div>

    <div class="flex-col">
      <p class="footer-title">Account</p>
      <router-link to="/login" style="text-decoration: none; color: #222;"><span class="footer-url">Log in</span></router-link>
      <router-link to="/register" style="text-decoration: none; color: #222;"><span class="footer-url">Register</span></router-link>
    </div>
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
