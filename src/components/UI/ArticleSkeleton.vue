<template>
  <div class="news-block">
    <div class="news-header article-skeleton-header"></div>

    <div style="padding: 8px 16px">
      <div class="flex-row">
        <div v-for="i in 3" class="category-link article-skeleton-category"></div>
      </div>
      <h4 class="article-skeleton-title"></h4>
      <div style="display: flex; flex-direction: row; justify-content: space-between; color: #666; font-size: 14px;">
        <div class="flex-row"><p>@</p><p class="article-skeleton-info"></p></div>
        <div class="flex-row"><p class="article-skeleton-info"></p><p> comments</p></div>
      </div>

      <div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between; color: #666; font-size: 14px;">
        <div class="flex-row"><p>Published on </p><p class="article-skeleton-info"></p></div>
        <div class="flex-row"><p class="article-skeleton-info"></p></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ArticleSkeleton"
}
</script>

<style scoped>
.article-skeleton-header {
  width: 416px;
  height: 192px;
  border-radius: 16px 16px 0 0;
  animation: pulse 1s infinite alternate linear;
}

.article-skeleton-category {
  width: 64px;
  height: 20px;
  margin-bottom: 8px;
  animation: pulse 2s infinite alternate linear;
}

.article-skeleton-title {
  width: 100%;
  height: 45px;
  animation: pulse 2s infinite alternate linear;
}

.article-skeleton-info {
  width: 96px;
  height: 20px;
  margin: 4px;
  animation: pulse 2s infinite alternate linear;
}

p {
  margin-top: 4px;
  margin-bottom: 4px;
}

h4 {
  margin: 0 0 8px 0;
  text-align: left;
}
</style>