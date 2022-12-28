<template>
  <div class="view">
    <section class="list" :style="reading && windowWidth < 721 ? 'display: none' : ''">
      <form @submit.prevent="search()">
        <img src="/src/assets/icons/search.png" alt="Search">
        <input type="text" placeholder="Search query" v-model="query">
      </form>

      <template v-if="results != null">
        <Article v-for="i in results.length" :data="results[i - 1]" prefix="/search" @click="reading = true" />
      </template>
    </section>

    <section class="reader" v-if="(reading && windowWidth < 721) || (windowWidth > 720)">
      <div v-if="!reading" style="display: flex; flex-direction: column; height: calc(100% - 60px); justify-content: center;">
        <span style="font-size: 1.5em; font-weight: bold;">Open an article</span>
        <span>Select an article from the left side</span>
      </div>

      <div id="viewer" v-else><router-view /></div>
    </section>
  </div>
</template>

<script>
import axios from "axios";
import Article from "../components/Article.vue";
import ArticleSkeleton from "../components/UI/ArticleSkeleton.vue";
import CategorySkeleton from "../components/UI/CategorySkeleton.vue";
import Category from "../components/Category.vue";

export default {
  name: "Search",
  components: { Article, ArticleSkeleton, CategorySkeleton, Category },
  data() {
    return {
      query: '',
      results: null,
      message: null,
      searching: false,
      categories: null,
      categoriesError: '',
      reading: false,
      windowWidth: window.innerWidth,
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
    },
    routeTo(cat) {
      this.$router.push('/category/' + cat)
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
    this.reading = this.$route.path.includes('article/')
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.onResize);
  },
  updated() {
    this.reading = this.$route.path.includes('article/')
  }
}
</script>

<style scoped>
form {
  margin: 1em 2em;
  display: flex;
  flex-direction: row;
  align-content: center;
}
form img {
  width: 1.25em;
  height: 1.25em;
  filter: var(--icon-color);
  margin: auto 0.75em auto 0;
}
form input {
  width: 100%;
  font-size: 1em;
  background: var(--text-tint);
  border: var(--border-thin);
  border-radius: 16px;
  outline: none;
  padding: 0.5em 1em;
  color: var(--text-color);
  transition: all 0.25s;
}
form input:focus {
  border-color: #A0CA97;
}
/* 
.search-form {
  display: flex;
  flex-direction: column;
  margin: 0.25rem auto 1rem;
  width: 100%;
}

.search-input {
  padding: 8px;
  font-size: 1rem;
  width: clamp(240px, 80%, 384px);
  outline: none;
  border-radius: 8px;
  background: transparent;
  color: var(--text-color);
  border: 2px solid var(--input-border-inactive);
  transition: .25s;
}

.search-label {
  font-size: 1.75rem;
  text-align: center;
  margin: 1.5rem auto 0.75rem;
  font-weight: bold;
}

.search-input:focus {
  border-color: var(--input-border);
}

.search-submit {
  padding: 8px;
  vertical-align: center;
  border-radius: 8px;
  background: #A0CA9755;
  cursor: pointer;
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

.category-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(256px, 1fr));
  gap: 1.5rem;
} */
</style>