<template>
  <div class="view">
    <section class="list" :style="reading && windowWidth < 721 ? 'display: none' : ''">
      <Article v-for="i in articles.length" :data="articles[i - 1]" @click="reading = true" />
    </section>

    <section class="reader" v-if="(reading && windowWidth < 721) || (windowWidth > 720)">
      <div v-if="!reading" style="display: flex; flex-direction: column; height: calc(100% - 60px); justify-content: center;">
        <span style="font-size: 1.5em; font-weight: bold;">Open an article</span>
        <span>Select an article from the left side</span>
      </div>

      <div id="viewer" v-else><router-view /></div>
    </section>

    <!-- <template v-if="category == null && region == null">
      <h1>Most <span class="highlight">read</span> stories past <span class="highlight">24 hours</span></h1>
      <div v-if="hottest != null" class="article-list hot-articles">
        <Article v-for="i in count" :data="hottest[i-1]" />
      </div>

      <div v-if="hottest == null && error == null" class="article-list hot-articles">
        <ArticleSkeleton v-for="i in count" />
      </div>
    </template>
    

    <h1 v-if="category == null && region == null">Latest News</h1>
    <h1 v-if="category != null">{{ category }} news</h1>
    <h1 v-if="region != null">News from {{ region }}</h1>

    <h2 style="text-align: justify; font-weight: normal;">{{ description }}</h2>

    {{ error }}

   <span style="font-size: 1.5rem; font-weight: bold; display: block; text-align: left; margin-bottom: 0.25rem">Sort news</span>
    <div class="flex-row" style="gap: 1rem; margin-bottom: 1rem;">
      <button type="button" :class="(sort == 0) ? 'sort-button-active' : 'sort-button'" @click="sort = 0">Latest</button>
      <button type="button" :class="(sort == 1) ? 'sort-button-active' : 'sort-button'" @click="sort = 1">Controversial</button>
      <button type="button" :class="(sort == 2) ? 'sort-button-active' : 'sort-button'" @click="sort = 2">Top Past Month</button>
      <button type="button" :class="(sort == 3) ? 'sort-button-active' : 'sort-button'" @click="sort = 3">Top All Time</button>
    </div>

    <div v-if="articles != null" class="article-list">
      <Article v-for="i in articles.length" :data="articles[i-1]" />
    </div>

    <div v-if="articles == null && error == null" class="article-list">
      <ArticleSkeleton v-for="i in 12" />
    </div> -->
  </div>
</template>

<script>
import Article from "../components/Article.vue";
import axios from "axios";
import ArticleSkeleton from "../components/UI/ArticleSkeleton.vue";
import ReadArticle from "./ReadArticle.vue";

export default {
  name: "Home",
  components: { Article, ArticleSkeleton, ReadArticle },
  watch: {
    $route: {
      immediate: true,
      handler(to, from) {
        document.title = to.meta.title || '16min';
        //this.articles = null
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
  },
  data() {
    return {
      articles: [
        {
          "id": 2944,
          "title": "Purdy leads 49ers past Commanders 37-20 for 8th straight win",
          "slug": "purdy-leads-49ers-past-commanders-37-20-for-8th-straight-win",
          "publish_date": "2022-12-25 16:32",
          "header_image": "iR87IzKiGcJ6QZ6R.webp",
          "name": "Washington Commanders",
          "rating": "0",
          "categories": [],
          "comments_count": 0
        },
        {
          "id": 2942,
          "title": "Whoopi Goldberg said she doesn't have to worry about aging unlike other actors in Hollywood: 'My stuff's going to sag and fall and I will be fine'",
          "slug": "whoopi-goldberg-said-she-doesnt-have-to-worry-about-aging-unlike-other-actors-in-hollywood-my-stuffs-going-to-sag-and-fall-and-i-will-be-fine",
          "publish_date": "2022-12-25 16:32",
          "header_image": "kGZwW9KKmP70E9jT.webp",
          "name": "Maria Noyen",
          "rating": "0",
          "categories": [],
          "comments_count": 0
        },
        {
          "id": 2941,
          "title": "Russians lost thousands of soldiers at Bakhmut",
          "slug": "russians-lost-thousands-of-soldiers-at-bakhmut",
          "publish_date": "2022-12-25 16:32",
          "header_image": "CuRkQ6fSZCosDTJL.webp",
          "name": "Ukrainska Pravda",
          "rating": "0",
          "categories": [],
          "comments_count": 0
        },
        {
          "id": 2937,
          "title": "International students in Canada get help from campuses and colleagues to keep holiday spirits alive",
          "slug": "international-students-in-canada-get-help-from-campuses-and-colleagues-to-keep-holiday-spirits-alive",
          "publish_date": "2022-12-25 16:31",
          "header_image": "EFNX8uzQjOXL6fFy.webp",
          "name": "Darryl Veld",
          "rating": "0",
          "categories": [],
          "comments_count": 0
        },
        {
          "id": 2936,
          "title": "Pele's family gathers around 82-year-old at hospital in Brazil",
          "slug": "peles-family-gathers-around-82-year-old-at-hospital-in-brazil",
          "publish_date": "2022-12-25 16:31",
          "header_image": "I8q6bKS2AbsM3q6J.webp",
          "name": "The Associated Press",
          "rating": "0",
          "categories": [],
          "comments_count": 0
        },
        {
          "id": 2933,
          "title": "Prince Philip's £60,000 eco-heating saving thousands on energy bills amid cost-of-living crisis",
          "slug": "prince-philips-60000-eco-heating-saving-thousands-on-energy-bills-amid-cost-of-living-crisis",
          "publish_date": "2022-12-25 16:30",
          "header_image": "Gy9sHKozO40iVV3v.webp",
          "name": "Andrew Young For",
          "rating": "0",
          "categories": [],
          "comments_count": 0
        },
        {
          "id": 2935,
          "title": "At least 180 Rohingya feared dead - U.N. refugee agency",
          "slug": "at-least-180-rohingya-feared-dead---un-refugee-agency",
          "publish_date": "2022-12-25 16:30",
          "header_image": "gA0xGR6nQ5RwXKjB.webp",
          "name": "Mayank Bhardwaj",
          "rating": "0",
          "categories": [],
          "comments_count": 0
        },
        {
          "id": 2930,
          "title": "Bariatric weight loss surgery is a ‘life-changing’ procedure at Penn Medicine",
          "slug": "bariatric-weight-loss-surgery-is-a-life-changing-procedure-at-penn-medicine",
          "publish_date": "2022-12-25 16:28",
          "header_image": "Tswv4qXIyXm9jWpL.webp",
          "name": "Michael Tanenbaum",
          "rating": "0",
          "categories": [],
          "comments_count": 0
        },
        {
          "id": 2932,
          "title": "Pope Francis says ‘icy winds of war buffet humanity’ in Christmas Day address",
          "slug": "pope-francis-says-icy-winds-of-war-buffet-humanity-in-christmas-day-address",
          "publish_date": "2022-12-25 16:27",
          "header_image": "x0fC3S5ktYsw1XXI.webp",
          "name": "Frances d'Emilio",
          "rating": "0",
          "categories": [],
          "comments_count": 0
        },
        {
          "id": 2931,
          "title": "Woman, 26, killed in Christmas Eve pub shooting was out with friends, police reveal",
          "slug": "woman-26-killed-in-christmas-eve-pub-shooting-was-out-with-friends-police-reveal",
          "publish_date": "2022-12-25 16:27",
          "header_image": "FmSo0Sm5WgppWoYC.webp",
          "name": "Furvah Array",
          "rating": "0",
          "categories": [],
          "comments_count": 0
        },
        {
          "id": 2928,
          "title": "Foreign aid groups in Afghanistan suspend work after Taliban ban on women workers",
          "slug": "foreign-aid-groups-in-afghanistan-suspend-work-after-taliban-ban-on-women-workers",
          "publish_date": "2022-12-25 16:25",
          "header_image": "5IuI27bnjj1Q7uCW.webp",
          "name": "16min Writers",
          "rating": "0",
          "categories": [],
          "comments_count": 0
        },
        {
          "id": 2926,
          "title": "King Charles III praises the Queen and workers in first Christmas message",
          "slug": "king-charles-iii-praises-the-queen-and-workers-in-first-christmas-message",
          "publish_date": "2022-12-25 16:20",
          "header_image": "uC3C7wcBdyaqH6ma.webp",
          "name": "Latika Bourke",
          "rating": "0",
          "categories": [],
          "comments_count": 0
        }
	    ],
      hottest: null,
      error: null,
      sort: 0,
      reading: false,
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
    this.reading = this.$route.path.includes('article/')
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.onResize);
  },
  updated() {
    this.reading = this.$route.path.includes('/article/')
  }
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
</style>