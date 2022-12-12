<template>
  <div class="view">
    <h1>Most <span class="highlight">read</span> stories past <span class="highlight">24 hours</span></h1>
    <div v-if="hottest != null" class="article-list hot-articles">
      <Article v-for="i in count" :data="hottest[i-1]" />
    </div>

    <div v-if="hottest == null && error == null" class="article-list hot-articles">
      <ArticleSkeleton v-for="i in count" />
    </div>

    <h1 v-if="category == null && region == null">Latest News</h1>
    <h1 v-if="category != null">{{ category }} news</h1>
    <h1 v-if="region != null">News from {{ region }}</h1>

    <h2 style="text-align: justify; font-weight: normal;">{{ description }}</h2>

    {{ error }}

    <!-- <span style="font-size: 1.5rem; font-weight: bold; display: block; text-align: left; margin-bottom: 0.25rem">Sort news</span>
    <div class="flex-row" style="gap: 1rem; margin-bottom: 1rem;">
      <button type="button" :class="(sort == 0) ? 'sort-button-active' : 'sort-button'" @click="sort = 0">Latest</button>
      <button type="button" :class="(sort == 1) ? 'sort-button-active' : 'sort-button'" @click="sort = 1">Controversial</button>
      <button type="button" :class="(sort == 2) ? 'sort-button-active' : 'sort-button'" @click="sort = 2">Top Past Month</button>
      <button type="button" :class="(sort == 3) ? 'sort-button-active' : 'sort-button'" @click="sort = 3">Top All Time</button>
    </div> -->

    <div v-if="articles != null" class="article-list">
      <Article v-for="i in articles.length" :data="articles[i-1]" />
    </div>

    <div v-if="articles == null && error == null" class="article-list">
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
      requestData.start = this.page * 12

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
    requestData.start = this.page * 12

    if (this.region != null) {
      requestData.type = 'region'
      requestData.region = this.region
    }
    requestData.start = this.page * 12

    if (this.region == null && this.category == null) {
      await axios.get('/api/hot.php?days=1&count=8').then(r => r.data).then(json => {
        if (json.success) {
          this.hottest = json.data
        }
      })
    }

    await axios.post('/api/getArticles.php', requestData).then(response => response.data).then(json => {
      if (json.success) this.articles = json.articles
      else this.error = json.message
    })

    this.count = parseInt(window.getComputedStyle(document.getElementsByClassName("hot-articles")[0],null).getPropertyValue("--data-count"));
    this.$watch('windowWidth', () => {
      this.count = parseInt(window.getComputedStyle(document.getElementsByClassName("hot-articles")[0],null).getPropertyValue("--data-count"));
    });
  },
  data() {
    return {
      articles: null,
      hottest: null,
      error: null,
      sort: 0,
      count: 4,
      windowWidth: window.innerWidth,
      description: "We post the latest news and stories from around the world, with a focus on the weird, the wacky, and the wonderful. From the latest celebrity gossip to the latest viral video, we've got you covered. And if you're looking for a good laugh, be sure to check out our selection of dank memes.",
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
    },
    region: {
      type: String,
      required: false,
      default: null
    }
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
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.onResize);
  },
}
</script>

<style scoped>
.sort-button {
  padding: 0.5rem 0.75rem;
  border-radius: 16px;
  border: 3px solid #4281A4;
  color: #4281A4;
  font-size: 1.15rem;
  background-color: transparent;
  cursor: pointer;
  transition: all 0.25s;
}

.sort-button:hover {
  background-color: #4281A4;
  color: #DCE2E5;
}

.sort-button-active {
  padding: 0.5rem 0.75rem;
  border-radius: 16px;
  color: #DCE2E5;
  font-size: 1.15rem;
  background-color: #4281A4;
  transition: all 0.25s;
  border: 3px solid #295166;
  transform: scale(110%);
}

@media (max-width: 768px) {
  .sort-button, .sort-button-active {
    font-size: 1rem;
    padding: 0.4rem 0.6rem;
  }
}

@media (max-width: 512px) {
  .sort-button, .sort-button-active {
    font-size: 0.9rem;
    padding: 0.25rem 0.5rem;
  }
}

.hot-articles {
  border-radius: 16px;
  border: 3px solid var(--emphasis-red);
  --data-count: 8;
  padding: 0.5em;
}
@media (max-width: 1560px) {
  .hot-articles {
    --data-count: 6;
  }
}
@media (max-width: 1170px) {
  .hot-articles {
    --data-count: 4;
  }
}
@media (max-width: 780px) {
  .hot-articles {
    --data-count: 2;
  }
}
</style>