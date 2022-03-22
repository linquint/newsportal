<template>
  <div class="news-block">
    <img class="news-header-image" :src="header" :alt="'Nuotrauka: ' + title">
    <div style="padding: 8px 16px">
      <p class="news-category">{{ JSON.stringify(categories) }}</p>
      <h4>{{ title }}</h4>
      <div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between; color: #666; font-size: 14px;">
        <p>@{{ author }}</p>
        <p>Published on {{ publishDate }}</p>
      </div>

      <div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between; color: #666; font-size: 14px;">
        <p>Rated at {{ rating }}</p>
        <p>{{ commentsAmount }} comments</p>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "Article",
  props: {
    title: String,
    author: String,
    commentsAmount: Number,
    slug: String,
    rating: Number,
    header: String,
    publishDate: Date,
    categories: Array
  },
  data() {
    return {

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
  box-shadow: 0 0 4px 1px #2c3e5099;
  transition: all 300ms ease-in-out;
}

.news-header-image {
  height: 192px;
  max-width: 416px;
  border-radius: 16px 16px 0 0;
}

.news-category {
  color: #2c3e50;
  font-size: 13px;
}

.news-author {
  color: #666;
}

.news-block:hover {
  box-shadow: 0 0 16px 4px #2c3e5099;
  transition: all 300ms ease-in-out;
}
</style>