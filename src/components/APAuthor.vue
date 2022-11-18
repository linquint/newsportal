<template>
<div class="ap-author-div flex-row">
  <div class="flex-col">
    <div class="flex-row">
      <div class="activity-indicator" />
      <p class="author-name">{{ name }}</p>
    </div>
    <p class="author-date-since">Author since: {{ authorSince }}</p>
  </div>

  <button style="height: 32px; margin-top: auto; margin-bottom: auto; margin-left: auto;">Manage author</button>
</div>
</template>

<script>
export default {
  name: "APAuthor",
  props: {
    name: String,
    authorSince: String,
    active: Boolean
  }
}
</script>

<style scoped>
.ap-author-div {
  border-radius: 8px;
  border: 1px solid #2c3e50;
  width: 384px;
  margin: 8px auto;
  padding: 4px;
}

.activity-indicator {
  height: 8px;
  width: 8px;
  border-radius: 50%;
  background: #42b983;
  border: 2px solid #308060;
  margin: auto 4px;
}

.author-name {
  font-size: 16px;
  margin: auto 0 auto 4px;
}

.author-date-since {
  font-size: 14px;
  margin: 8px 0 4px 8px;
  font-weight: bold;
}
</style>