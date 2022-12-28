<template>
  <div class="view">
    <section class="list" :style="action && windowWidth < 721 ? 'display: none' : ''">
      <template v-if="author">
        <router-link :to="{ path: '/panel/authors' }" style="text-decoration: none;"><div class="account-button">Manage Authors</div></router-link>
        <router-link :to="{ path: '/panel/create' }" style="text-decoration: none;"><div class="account-button">Create Author</div></router-link>
      </template>
    </section>

    <section class="reader" v-if="(action && windowWidth < 721) || (windowWidth > 720)">
      <span v-if="!author" class="account-container" style="font-size: 1.5em; font-weight: bold;">You do not have access to this content</span>

      <router-view v-else />
    </section>
  </div>

  <!-- <div class="view">
    <div v-if="author" class="flex-row" style="margin: 16px auto 0;">
      <router-link :to="{ path: '/author-panel/articles' }" style="text-decoration: none; color: #222;">
        <div class="nav-button">
          <img src="/src/assets/icons/news.png" alt="Articles" class="nav-icon">
          <span class="navigation-text">My articles</span>
        </div>
      </router-link>

      <router-link :to="{ path: '/author-panel/write' }" style="text-decoration: none; color: #222;">
        <div class="nav-button">
          <img src="/src/assets/icons/edit.png" alt="Write" class="nav-icon">
          <span class="navigation-text">Write a new article</span>
        </div>
      </router-link>
    </div>

    <div v-else>
      <h2>You're not an author</h2>
    </div>

    <router-view></router-view>
  </div> -->
</template>

<script>
import axios from "axios";

export default {
  name: "AuthorPanel",
  data() {
    return {
      author: false,
      action: false,
      windowWidth: window.innerWidth,
    }
  },
  async created() {
    await axios.post('/api/isLoggedIn.php').then(response => response.data).then(async json => {
      if (!json['loggedIn']) await this.$router.push('/account')
    })

    await axios.post('/api/details.php', { 'request': 'is_author', 'username': localStorage.getItem('user') }).then(response => response.data).then(json => {
      if (json.success) this.author = json.author
    })
  },
  methods: {
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
    this.action = this.$route.path.includes('author-panel/')
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.onResize);
  },
  updated() {
    this.action = this.$route.path.includes('author-panel/')
  }
}
</script>

<style scoped>

</style>