<template>
  <div class="view">
    <h1 v-if="category == null">News</h1>
    <h1 v-else>{{ category }} news</h1>

    {{ error }}

    <div v-if="articles != null" style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-evenly;">
      <Article v-for="i in articles.length" :data="articles[i-1]" />
    </div>

    <div v-if="articles == null && error == null" style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-evenly;">
      <ArticleSkeleton v-for="i in 12" />
    </div>
  </div>
</template>

<script>
import Article from "../components/Article.vue";
import axios from "axios";
import ArticleSkeleton from "../components/UI/ArticleSkeleton.vue";

export default {
  name: "Home",
  components: { Article, ArticleSkeleton },
  watch: {
    $route: {
      immediate: true,
      handler(to, from) {
        document.title = to.meta.title || '16min';
        this.articles = null
      }
    },
  },
  async updated() {
    if (this.articles == null) {
      let requestData = {}
      if (this.category != null) {
        requestData.type = 'category'
        requestData.category = this.category
      }
      requestData.start = this.page * 24

      await axios.post('/api/getArticles.php', requestData).then(response => response.data).then(json => {
        if (json.success) this.articles = json.articles
        else this.error = json.message
      })
    }
  },
  async created() {
    let requestData = {}
    if (this.category != null) {
      requestData.type = 'category'
      requestData.category = this.category
    }
    requestData.start = this.page * 24

    await axios.post('/api/getArticles.php', requestData).then(response => response.data).then(json => {
      if (json.success) this.articles = json.articles
      else this.error = json.message
    })
  },
  data() {
    return {
      articles: null,
      error: null,
    }
  },
  props: {
    category: {
      type: String,
      required: false,
      default: null
    },
    page: {
      type: Number,
      required: false,
      default: 0
    }
  },
}
</script>

<style scoped>

</style>