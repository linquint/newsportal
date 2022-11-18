<template>
  <div class="view">
    <h2 v-if="article == null && message == null">Loading article...</h2>
    <h3 v-else-if="article == null && message != null">{{ message }}</h3>
    <div v-else>
      <h1>{{ article.title }}</h1>

      <div class="flex-row">
        <button class="action-button" type="button" @click="rateArticle()">
          <img src="/src/assets/icons/like.png" alt="like" class="action-icon">
          <span style="margin: auto 0">Like</span>
        </button>

        <button class="action-button" type="button" @click="rateArticle(false)">
          <img src="/src/assets/icons/dislike.png" alt="dislike" class="action-icon">
          <span style="margin: auto 0">Dislike</span>
        </button>
      </div>

      <div class="article-block">
        <p v-html="article.content" class="article-text"></p>
      </div>

      <a v-if="!showComments" href="#" @click.prevent="loadComments()" style="text-decoration: none; color: #222222">
        <div class="login-button">
          <span>Show comments</span>
        </div>
      </a>

      <div v-if="showComments">
        <img v-if="showComments && comments == null" src="/src/assets/loading-comments.svg" alt="Loading" style="width: 32px; height: 32px;">

        <form v-if="showComments && (comments != null || commentsMessage != null)" class="flex-col" @submit.prevent="postComment(replyTo != null)">
          <div v-if="replyTo != null" class="comment-reply-block" style="width: var(--comment-width)">
            <p class="comment-reply-title">Replying to comment by <span class="comment-reply-user">{{ comments[replyTo].reply.username }}</span></p>

            <p class="comment-reply-content">{{ comments[replyTo].reply.content }}</p>
            <a href="#" style="text-decoration: none; color: #BE3A4E" @click.prevent="replyTo = null">Cancel reply</a>
          </div>

          <textarea class="login-input" v-model="commentContent"></textarea>
          <input class="login-submit" type="submit" value="Post comment">
        </form>

        <h3 v-if="commentsMessage != null">{{ commentsMessage }}</h3>

        <div v-if="comments.length > 0">
          <Comment
              v-for="i in comments.length"
              :comment="comments[i-1]"
              :cid="i - 1"
              :mod="userDetails.isAdmin ?? false"
              @set-reply-to="setReplyTo"
              @set-deleted="setCommentDeleted"
          />
        </div>
        <h3 v-else-if="commentsMessage == null">This article doesn't have any comments yet!</h3>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Comment from "../components/Comment.vue"

export default {
  name: "ReadArticle",
  components: { Comment },
  data() {
    return {
      article: null,
      message: null,
      rating: {
        likes: 0,
        dislikes: 0
      },
      showComments: false,
      comments: null,
      commentsMessage: null,
      replyTo: null,
      commentContent: '',
      userDetails: null,
    }
  },
  props: {
    slug: {
      required: true,
      type: String
    }
  },
  async created() {
    await axios.post('/api/getArticles.php', {
      type: 'slug',
      slug: this.slug
    }).then(response => response.data).then(json => {
      if (json.success) {
        this.article = json.article
        this.getModAccess()
      } else this.message = json.message
    })
  },
  methods: {
    async rateArticle(liked = true) {
      await axios.post('/api/rate.php', {
        article: this.article.id,
        liked: liked
      }).then(response => response.data).then(json => {
        if (json.success) this.rating = json.stats
        else this.message = json.message
      })
    },
    async getRatings() {
      await axios.post('/api/rate.php', {
        article: this.article.id
      }).then(response => response.data).then(json => {
        if (json.success) this.rating = json.stats
      })
    },
    async loadComments() {
      this.showComments = true

      await axios.post('/api/comment.php', {
        action: 'get',
        article: this.article.id
      }).then(response => response.data).then(json => {
        if (json.success) this.comments = json.comments
        else this.commentsMessage = json.message
      })
    },
    async postComment(isReply = false) {
      let data = {
        action: 'post',
        article: this.article.id,
        content: this.commentContent
      }
      if (isReply) data.main = this.comments[this.replyTo].reply.cid

      await axios.post('/api/comment.php', data).then(response => response.data).then(json => {
        if (json.success) this.comments = json.comments
        else this.commentsMessage = json.message
      })
    },
    setReplyTo(event) {
      console.log(event)
      this.replyTo = event
    },
    async getModAccess() {
      await axios.post('/api/details.php', { request: 'get_details' }).then(response => response.data).then(json => {
        this.userDetails = json
        this.getRatings()
      })
    },
    async setCommentDeleted(event) {
      await axios.post('/api/comment.php', {
        action: 'delete',
        comment: this.comments[event].reply.cid
      }).then(response => response.data).then(json => {
        if (json.success) this.comments = json.comments
      })
    }
  }
}
</script>

<style scoped>
.action-button {
  font-size: 14px;
  display: flex;
  flex-direction: row;
  margin: 4px 16px;
  background: transparent;
  outline: none;
  border: none;
  transition: all .2s;
  padding: 8px;
  border-radius: 8px;
}

.action-button:hover {
  transform: scale(120%);
  background: #FAC898;
}

.action-icon {
  height: 24px;
  aspect-ratio: 1;
  margin-right: 8px;
}

.article-block {
  width: 50%;
  margin: 0 auto;
}

.article-text {
  text-align: left;
}

.login-input {
  width: var(--comment-width);
  margin: 8px auto;
}

.login-submit {
  margin: 8px auto;
}
</style>