<template>
  <router-link :to="'/article/' + data.slug" style="text-decoration: none; color: #222;">
    <div class="news-block">
      <div class="news-header">
        <img class="news-header-image" :src="'data:image;base64,' + data.header_image" :alt="'Photo: ' + data.title">
      </div>

      <div style="padding: 8px 16px">
        <div class="flex-row">
          <router-link v-for="i in data.categories.length" class="news-category" :to="'/category/' + data.categories[i-1]" style="text-decoration: none; margin-right: 8px;">
            <span class="category-link">{{ data.categories[i - 1] }}</span>
          </router-link>
        </div>
        <h4>{{ data.title }}</h4>
        <div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between; color: #666; font-size: 14px;">
          <p>@{{ data.author }}</p>
          <p>{{ data.comments_count }} comments</p>
        </div>

        <div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between; color: #666; font-size: 14px;">
          <p>Published on {{ data.publish_date }}</p>
          <p :style="ratingStyle() + '; font-weight: bold;'">{{ ratingText() }}</p>
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
  data() {
    return {

    }
  },
  methods: {
    ratingText() {
      if (this.data.rating === 0) {
        return "No rating"
      } else {
        if (this.data.rating > 0) return '+' + this.data.rating
        else return '-' + this.data.rating
      }
    },
    ratingStyle() {
      if (this.data.rating === 0) {
        return "color: #666"
      } else {
        if (this.data.rating > 0) return 'color: #00b300'
        else return 'color: #ff0000'
      }
    }
  }
}
</script>

<style scoped>
p {
  margin: 0;
}

h4 {
  margin: 0 0 8px 0;
  text-align: left;
}

.news-block {
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
  width: 416px;
  border-radius: 16px;
  margin: 16px 0;
  box-shadow: 0 0 2px 2px #2c3e5099;
  transition: all 200ms ease-in-out;
}

.news-header-image {
  height: 192px;
  min-width: 416px;
  border-radius: 16px 16px 0 0;
  object-fit: cover;
  transition: all .4s ease-in;
}

.news-block:hover .news-header-image {
  transform: scale(110%);
}

.news-header {
  overflow: hidden;
  height: 192px;
  max-width: 416px;
  border-radius: 16px 16px 0 0;
  object-fit: cover;
}

.news-category {
  color: #2c3e50;
  font-size: 13px;
}

.news-author {
  color: #666;
}

.news-block:hover {
  box-shadow: 0 0 8px 8px #2c3e50;
  transition: all 200ms ease-in-out;
}

.category-link {
  color: #42b983;
  font-size: 14px;
  transition: all 0.2s;
}

.category-link:hover {
  color: #308060;
}
</style>