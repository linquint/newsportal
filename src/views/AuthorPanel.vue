<template>
  <div class="view">
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
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "AuthorPanel",
  data() {
    return {
      author: false,
    }
  },
  async created() {
    await axios.post('/api/isLoggedIn.php').then(response => response.data).then(async json => {
      if (!json['loggedIn']) await this.$router.push('/account')
    })

    await axios.post('/api/details.php', { 'request': 'is_author', 'username': localStorage.getItem('user') }).then(response => response.data).then(json => {
      if (json.success) this.author = json.author
    })
  }
}
</script>

<style scoped>

</style>