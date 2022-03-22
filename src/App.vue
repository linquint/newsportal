<template>
  <div class="container">
    <nav>
      <h1 class="brand">16min</h1>

      <router-link :to="{name: 'Home'}" style="text-decoration: none; color: #222;">
        <div class="nav-button">
          <img src="/src/assets/icons/news.png" alt="News" class="nav-icon">
          <span class="navigation-text">Naujienos</span>
        </div>
      </router-link>

      <router-link :to="{name: 'Search'}" style="text-decoration: none; color: #222;">
        <div class="nav-button">
          <img src="/src/assets/icons/search.png" alt="Search" class="nav-icon">
          <span class="navigation-text">Paieška</span>
        </div>
      </router-link>

      <!--      <router-link :to="{name: 'Home'}" style="text-decoration: none; color: #222;">
              <div class="nav-button">
                <img src="/src/assets/icons/bookmark-full.png" alt="Saved Articles" class="nav-icon">
                <span class="navigation-text">Išsaugoti straipsniai</span>
              </div>
            </router-link>-->

      <router-link :to="{name: 'Account'}" style="text-decoration: none; color: #222; margin: 0 0 0 auto;">
        <div class="nav-button">
          <img src="/src/assets/icons/user.png" alt="User" class="nav-icon">
          <span class="navigation-text">Paskyra</span>
        </div>
      </router-link>

    </nav>

    <router-view />
  </div>
</template>

<script>
export default {
  name: "App",
  data() {
    return {

    }
  },
  computed: {
    width() {
      return window.innerWidth
    }
  },
  methods: {

  },
  watch: {
    $route: {
      immediate: true,
      handler(to, from) {
        document.title = to.meta.title || 'Some Default Title';
      }
    },
  },
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,900&display=swap');

#app {
  font-family: Nunito, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  display: flex;
  flex-direction: row;
  padding: 16px 0;
  position: fixed;
  width: var(--width);
  background: white;
  top: 0;
}

.flex-row {
  display: flex;
  flex-direction: row;
}

.brand {
  margin: 0 32px 0 0;
  font-size: 30px;
}

.nav-button {
  padding: 8px 16px;
  display: flex;
  flex-direction: row;
  margin: 0 12px;
  border-radius: 8px;
  transition: all 300ms ease-in-out;
}

.nav-button:hover {
  background: #A0CA97;
  border-radius: 8px;
  box-shadow: 0 4px 8px 4px #A0CA9799;
  transform: scale(110%);
  transition: all 300ms ease-in-out;
}
</style>
