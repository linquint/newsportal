<template>
  <router-link :to="'/article/' + data.slug" style="text-decoration: none; color: #222;">
    <div class="news-block">
      <div class="news-header">
        <img id="article-image" class="news-header-image" :src="getImageSrc()" :alt="'Photo: ' + data.title">
      </div>

      <div style="padding: 8px 16px">
        <div class="flex-row">
          <router-link v-for="i in data.categories.length" :to="'/category/' + data.categories[i-1].title" style="text-decoration: none; margin-right: 8px;">
            <span class="category-link">{{ data.categories[i - 1].title }}</span>
          </router-link>
        </div>
        <span class="news-title">{{ data.title }}</span>
        <div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between; color: #666; font-size: 0.9rem;">
          <p>@{{ data.name }}</p>
        </div>

        <div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between; color: #666; font-size: 0.9rem;">
          <p>{{ data.publish_date }}</p>
          <p :style="ratingStyle() + '; font-weight: bold;'">{{ data.rating }}</p>
        </div>
      </div>
    </div>
  </router-link>
</template>

<script>
export default {
  name: "Article",
  props: {
    data: {
      required: true,
      type: Object
    }
  },
  async created() {
    
  },
  data() {
    return {
      imgData: null,
    }
  },
  methods: {
    ratingStyle() {
      if (this.data.rating === 0) {
        return "color: #666"
      } else {
        if (this.data.rating > 0) return 'color: #00b300'
        else return 'color: #ff0000'
      }
    },
    getImageSrc() {
      if (this.data.header_image == null) {
        return '/src/demo/photo.jpg'
      } else {
        return 'data:image;base64,' + this.data.header_image
      }
    }
  }
}
</script>

<style scoped>
p {
  margin: 0;
}

.news-header-image {
  aspect-ratio: 13/6;
  width: 100%;
  object-fit: cover;
  border-radius: 8px;
  transition: all .3s ease-in;
}

.news-block:hover .news-header-image {
  transform: scale(115%);
}

.news-header {
  overflow: hidden;
  aspect-ratio: 13/6;
  width: 100%;
  object-fit: cover;
  border-radius: 8px;
}

.news-title {
  font-size: 1rem;
  text-align: left;
  margin: 0.5rem auto;
  color: #2c3e50;
  display: block;
  width: 100%;
}

.category-link {
  color: #42b983;
  font-size: 1rem;
  transition: all 0.2s;
}

.category-link:hover {
  color: #308060;
  text-decoration: underline 1px #308060;
}
</style>