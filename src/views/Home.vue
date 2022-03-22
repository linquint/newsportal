<template>
  <div class="view">
    <h1>Naujienos</h1>

    <div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-evenly;">
      <Article
          header="/src/demo/photo.jpg"
          title="FNTT: Lietuvoje dėl sankcijų Rusijai ir Baltarusijai įšaldyta 13 mln. eurų"
          author="Antanas Antanauskas"
          commentsAmount=12
          slug="fntt-lietuvoje-del-sankciju-rusijai-ir-baltarusijai-isaldyta-13-mln-euru"
          rating=41
          publishDate="2022-03-12"
          :categories="cats"
      />

      <Article
          header="/src/demo/photo.jpg"
          title="FNTT: Lietuvoje dėl sankcijų Rusijai ir Baltarusijai įšaldyta 13 mln. eurų"
          author="Antanas Antanauskas"
          commentsAmount=12
          slug="fntt-lietuvoje-del-sankciju-rusijai-ir-baltarusijai-isaldyta-13-mln-euru"
          rating=41
          publishDate="2022-03-12"
          :categories="cats"
      />

      <Article
          header="/src/demo/photo.jpg"
          title="FNTT: Lietuvoje dėl sankcijų Rusijai ir Baltarusijai įšaldyta 13 mln. eurų"
          author="Antanas Antanauskas"
          commentsAmount=12
          slug="fntt-lietuvoje-del-sankciju-rusijai-ir-baltarusijai-isaldyta-13-mln-euru"
          rating=41
          publishDate="2022-03-12"
          :categories="cats"
      />

      <Article
          header="/src/demo/photo.jpg"
          title="FNTT: Lietuvoje dėl sankcijų Rusijai ir Baltarusijai įšaldyta 13 mln. eurų"
          author="Antanas Antanauskas"
          commentsAmount=12
          slug="fntt-lietuvoje-del-sankciju-rusijai-ir-baltarusijai-isaldyta-13-mln-euru"
          rating=41
          publishDate="2022-03-12"
          :categories="cats"
      />

      <Article
          header="/src/demo/photo.jpg"
          title="FNTT: Lietuvoje dėl sankcijų Rusijai ir Baltarusijai įšaldyta 13 mln. eurų"
          author="Antanas Antanauskas"
          commentsAmount=12
          slug="fntt-lietuvoje-del-sankciju-rusijai-ir-baltarusijai-isaldyta-13-mln-euru"
          rating=41
          publishDate="2022-03-12"
          :categories="cats"
      />
    </div>

  </div>
</template>

<script>
import Article from "../components/Article.vue";

export default {
  name: "Home",
  components: { Article, },
  data() {
    return {
      cats: ["Lietuvoje"]
    }
  },
  props: ['category'],
}
</script>

<style scoped>

</style>