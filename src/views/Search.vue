<template>
  <div class="view">
    <h1>Search</h1>
    <form @submit.prevent="search()" class="search-form">
      <label for="search" class="login-label">Search</label>
      <div style="display: flex; flex-direction: row;">
        <input type="text" id="search" name="search" placeholder="Search query" v-model="query" class="search-input">
        <button type="submit" class="search-submit">
          <img src="/src/assets/icons/search.png" alt="Search" class="search-icon">
        </button>
      </div>
    </form>

    <div v-if="results != null" style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-evenly;">
      <Article v-for="i in results.length" :data="results[i-1]" />
    </div>
    <div v-if="message != null">
      {{ message }}
    </div>

    <div v-if="searching" style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-evenly;">
      <ArticleSkeleton v-for="i in 12" />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Article from "../components/Article.vue";
import ArticleSkeleton from "../components/UI/ArticleSkeleton.vue";

export default {
  name: "Search",
  components: { Article, ArticleSkeleton },
  data() {
    return {
      query: '',
      results: null,
      message: null,
      searching: false,
    }
  },
  methods: {
    async search() {
      this.message = null
      this.results = null
      this.searching = true

      await axios.post('/api/search.php', {
        'search': this.query
      }).then(response => response.data).then(json => {
        if (json.success) this.results = json.articles
        else this.message = json.message

        this.searching = false
      })
    }
  }
}
</script>

<style scoped>
.search-form {
  display: flex;
  flex-direction: column;
  margin: 0 auto;
}

.search-input {
  padding: 8px;
  font-size: 16px;
  width: 360px;
  margin-right: 16px;
  outline: none;
  border-radius: 8px;
  border: 2px solid #2c3e5077;
  transition: .25s;
}

.search-input:focus {
  border-color: #2c3e50;
}

.search-submit {
  padding: 8px;
  vertical-align: center;
  border-radius: 50%;
  background: white;
  width: 40px;
  border: none;
  transition: .25s;
}

.search-submit:hover {
  background: #A0CA97;
  box-shadow: 0 0 8px 2px #A0CA9799;
}

.search-icon {
  width: 16px;
  aspect-ratio: 1;
}
</style>