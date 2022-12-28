<template>
  <router-link :to="prefix + '/article/' + data.slug" style="text-decoration: none; color: #222;">
    <div class="news-block">
      <img id="article-image" class="news-header-image" :src="getImageSrc()" alt="">
      <span class="news-title">{{ data.title }}</span>

      <div style="grid-column: 1 / 3; margin-top: 0.5em; display: flex; gap: 0.75em;">
        <span class="news-detail">{{ data.name }}</span>
        <span class="news-detail">{{ postTimeAgo() }}</span>
        <span class="news-detail" :style="ratingStyle() + '; font-weight: bold'">{{ data.rating }}</span>
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
    },
    prefix: {
      required: false,
      type: String,
      default: ''
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
      if (this.data.rating == 0) {
        return "color: #ff7700"
      } else {
        if (this.data.rating > 0) return 'color: #00b300'
        else return 'color: #ff0000'
      }
    },
    getImageSrc() {
      if (this.data.header_image == null) {
        return 'http://54.195.54.174/src/demo/photo.jpg'
      } else if (this.data.header_image == "none.png") {
        return 'http://54.195.54.174/images/none.png'
      } else {
        let img = this.data.header_image
        if (img.includes('.png') || img.includes('.jpg') || img.includes('.gif') || img.includes('.webp')) {
          return 'http://54.195.54.174/thumbnail/small_' + this.data.header_image
        }
        return 'http://54.195.54.174/thumbnail/small_' + this.data.header_image + '.webp';
      }
    },
    postTimeAgo() {
      let now = new Date()
      let ms = (now - new Date(this.data.publish_date))
      let mins = Math.ceil(ms / 60000)
      if (mins < 60) return mins + 'min'

      let hrs = Math.floor(mins / 60)
      if (hrs < 24) return hrs + 'h'

      return Math.floor(hrs / 24) + 'd'
    }
  },
}
</script>

<style scoped>
p {
  margin: 0;
}
</style>