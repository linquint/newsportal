<template>
  <h3 v-if="count === 0">Downloading list of authors</h3>
  <h3 v-if="error !== '' && count !== 0">{{ error }}</h3>
  <div v-if="count > 0">
    <h5 style="text-align: left; width: 384px; margin: auto">Author count: {{ count }}</h5>
    <APAuthor v-for="i in authors.length" :active="authors[i-1].active === 1" :author-since="authors[i-1].date_since" :name="authors[i-1].name" />
  </div>
  <router-link :to="{path: '/panel'}" style="text-decoration: none; color: #222; width: min-content; margin: 0 auto;"><div class="cancel-button">Cancel</div></router-link>
</template>

<script>
import axios from "axios";
import APAuthor from "../../components/APAuthor.vue";

export default {
  name: "ManageAuthors",
  components: { APAuthor },
  data() {
    return {
      count: 0,
      authors: [],
      error: '',
    }
  },
  async created() {
    await axios.post('/api/authors.php').then(response => response.data).then(json => {
      if (json.success) {
        console.log(json.data.authors)

        this.authors = json.data.authors
        this.count = json.data.count
      } else {
        this.error = json.message
        this.count = 0
      }
    })
  }
}
</script>

<style scoped>

</style>