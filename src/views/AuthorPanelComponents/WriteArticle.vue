<template>
  <form @submit.prevent="postArticle(title, slug, content)" class="wa-form">
    <label for="title" class="wa-label">Title</label>
    <input type="text" id="title" name="title" maxlength="255" class="wa-input" v-model="title">

    <label for="slug" class="wa-label">Slug</label>
    <input type="text" id="slug" name="slug" class="wa-input" v-model="slug">
    <p class="wa-field-note">Slug example: www.domain.tld/<strong>this-is-slug</strong></p>
    <a href="#" @click="generateSlug()">Generate from title</a>

    <label for="headerimg" class="wa-label">Header image</label>
    <input type="file" id="headerimg" name="headerimg" class="wa-input" @change="handleFileUpload($event)">
    <p class="wa-field-note">Aspect ratio: <strong>19.5 : 9</strong></p>

    <label class="wa-label" for="category">Categories</label>
    <div v-if="categoriesList != null" style="width: 100%">
      <input class="wa-input" type="text" placeholder="Find category" v-model="searchQuery" id="category">
      <div v-if="searchQuery !== ''" style="display: flex; flex-direction: row; flex-wrap: wrap;">
        <template v-for="i in categoriesList.length">
          <button v-if="displayResult(i - 1)" class="cs-added" @click="handleSelection(categoriesList[i - 1])">
            <span>{{ categoriesList[i - 1].title }}</span>
          </button>
        </template>
      </div>
    </div>

    <label class="wa-label" for="selectedCategories">Selected categories</label>
    <div>
      <div v-if="categories.length > 0" style="display: flex; flex-direction: row; flex-wrap: wrap;">
        <span class="cs-added" v-for="i in categories.length" @click="handleSelection(categories[i - 1])">{{ categories[i - 1].title }}</span>
      </div>
      <p v-else>You haven't selected any</p>
    </div>

    <label for="content" class="wa-label">Contents of the article</label>
    <textarea id="content" name="content" class="wa-input" v-model="content" style="height: 420px" />

    <input type="submit" name="post" value="Post article" class="login-submit">

    <h5>{{ message }}</h5>
  </form>
</template>

<script>
import axios from "axios";

export default {
  name: "WriteArticle",
  async created() {
    await axios.post('/api/getCategoriesList.php').then(response => response.data).then(json => {
      console.log("JSON = " + JSON.stringify(json))

      this.categoriesList = json

      console.log("JSON = " + JSON.stringify(this.categoriesList))
    })
  },
  data() {
    return {
      title: '',
      slug: '',
      header: '',
      content: '',
      message: '',
      categories: [],
      categoriesList: null,
      searchQuery: '',
      selectedCategories: [],
    }
  },
  methods: {
    async postArticle(title, slug, content) {
      let formData = new FormData()
      formData.append('title', title)
      formData.append('slug', slug)
      formData.append('image', this.header)
      formData.append('categories', JSON.stringify(this.categories))
      formData.append('content', content)

      await axios.post('/api/post-article.php', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then(response => response.data).then(json => {
        console.log(json)

        this.message = json.message
      })
    },
    handleFileUpload(event) {
      this.header = event.target.files[0]
    },
    generateSlug(title = this.title) {
      title = title.toLowerCase()
      let tmp = ''

      for (let i = 0; i < title.length; i++) {
        let letter = title[i]
        if (letter === ' ') tmp += '-'
        if ('a' <= letter && letter <= 'z' || 'A' <= letter && letter <= 'Z') tmp += letter
      }

      title = tmp
      this.slug = title
    },
    handleSelection(item) {
      if (this.categories.includes(item)) {
        this.categories = this.categories.filter((element, id) => {
          const delID = this.categories.indexOf(item)
          if (id !== delID) return element
        })
      } else {
        this.categories.push(item)
      }
      this.searchQuery = ''
    },
    displayResult(id) {
      return this.categoriesList[id].title.toLowerCase().includes(this.searchQuery.toLowerCase()) && !this.categories.includes(this.categoriesList[id])
    }
  }
}
</script>

<style>
  .cs-added {
    background: #308060;
    color: aliceblue;
    border-radius: 8px;
    padding: 8px;
    margin: 8px;
    font-size: 12px;
    cursor: pointer;
    border: none;
  }
</style>