<template>
  <div class="news-block">
    <div class="news-header article-skeleton-header"></div>

    <div style="padding: 8px 16px">
      <div class="flex-row">
        <div v-for="i in 3" class="article-skeleton-category"></div>
      </div>
      <h4 class="article-skeleton-title"></h4>
      <div class="flex-row" style="color: #666; font-size: 0.9rem;"><p>@</p><p class="article-skeleton-info"></p></div>
      <div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between;">
        <div class="article-skeleton-info" />
        <div class="article-skeleton-info" style="width: 32px" />
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
  width: 100%;
  aspect-ratio: 13/6;
  border-radius: 8px;
  animation: pulse 1.5s infinite alternate linear;
}

.article-skeleton-category {
  width: 64px;
  height: calc(1rem + 2px);
  margin-bottom: 0.5rem;
  margin-right: 0.5rem;
  border-radius: 8px;
  animation: pulse 1.5s infinite alternate linear;
}

.article-skeleton-title {
  width: 100%;
  height: 66px;
  border-radius: 8px;
  animation: pulse 1.5s infinite alternate linear;
}

.article-skeleton-info {
  width: 96px;
  height: 20px;
  margin: 4px;
  border-radius: 8px;
  animation: pulse 1.5s infinite alternate linear;
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