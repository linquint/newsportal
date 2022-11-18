<template>
  <h3 v-if="count === 0">Downloading list of authors</h3>
  <h3 v-if="error !== '' && count !== 0">{{ error }}</h3>
  <div v-if="count > 0">
    <h5 style="text-align: left; width: 384px; margin: auto">Author count: {{ count }}</h5>
    <APAuthor v-for="i in authors.length" :active="authors[i-1].active === 1" :author-since="authors[i-1].date_since" :name="authors[i-1].fname + ' ' + authors[i-1].lname" />
  </div>
  <router-link :to="{path: '/author-panel'}" style="text-decoration: none; color: #222; width: min-content; margin: 0 auto;"><div class="cancel-button">Cancel</div></router-link>
</template>

<script>
export default {
  name: "ArticleList"
}
</script>

<style scoped>

</style>