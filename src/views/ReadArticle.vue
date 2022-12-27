<template>
  <div class="view">
    <h2 v-if="article == null && message == null">Loading article...</h2>
    <h3 v-else-if="article == null && message != null">{{ message }}</h3>
    <div v-else>
      <div v-if="imageData == null" class="image-skeleton" />
      <template v-else-if="!imageData" />
      <img v-else-if="imageData != 'none.png'" class="article-image" :src="imageData" :alt="'Photo: ' + article.title">

      <h1 style="font-size: var(--article-font-size); text-align: left;">{{ article.title }}</h1>

      <div class="article-data-row">
        <div class="flex-row" style="gap: 2rem">
          <div style="margin: auto 0">
            <img src="/src/assets/icons/like.png" alt="like" class="action-icon" />
            <span style="margin: auto 0;">{{ rating.likes }}</span>
          </div>

          <div style="margin: auto 0">
            <img src="/src/assets/icons/dislike.png" alt="dislike" class="action-icon" />
            <span style="margin: auto 0">{{ Math.abs(rating.dislikes) }}</span>
          </div>
        </div>

        <div class="flex-col">
          <span style="text-align: left;">
            By 
            <router-link style="text-align: left; text-decoration: none;" :to="'/author/' + article.name">
              <span class="article-author">{{ article.name }}</span>
            </router-link>
          </span>

          <span style="text-align: left;">Published on {{ article.publish_date }}</span>
        </div>
      </div>

      <p v-if="article.summary != null" v-html="article.summary" class="article-summary"></p>
      <p v-html="article.content" class="article-text"></p>

      <span style="font-size: 1rem; font-weight: bold; display: block; text-align: left; margin-top: 0.5rem;">Did you like this article?</span>
      <div class="flex-row">
        <button class="action-button" type="button" @click="rateArticle()">
          <img src="/src/assets/icons/like.png" alt="like" class="action-icon" />
          <span style="margin: auto 0">Like</span>
        </button>

        <button class="action-button" type="button" @click="rateArticle(false)">
          <img src="/src/assets/icons/dislike.png" alt="dislike" class="action-icon" />
          <span style="margin: auto 0">Dislike</span>
        </button>
      </div>

      <template v-if="article.categories.length > 0">
        <span style="font-size: 1rem; font-weight: bold; display: block; text-align: left;">Discover more from <span class="highlight">{{ (article.categories.length > 1) ? 'these categories' : 'this category' }}</span></span>
        <div class="flex-row" style="gap: 1rem;">
          <router-link v-for="i in article.categories.length" :to="'/category/' + article.categories[i-1].title" style="text-decoration: none;">
            <span class="category-link">{{ article.categories[i - 1].title }}</span>
          </router-link>
        </div>
      </template>

      <span style="font-size: 1rem; font-weight: bold; display: block; text-align: left;">Discover what else has happened in <span class="highlight">{{ article.region }}</span></span>
      <div class="flex-row" style="gap: 1rem;">
        <router-link :to="'/region/' + article.region" style="text-decoration: none;">
          <span class="category-link">{{ article.region }}</span>
        </router-link>
      </div>

      <span style="font-size: 1rem; font-weight: bold; display: block; text-align: left;">Would like to read <span class="highlight">original article</span> instead?</span>
      <div class="flex-row" style="gap: 1rem;">
        <a :href="article.origin" style="text-decoration: none;" target="_blank">
          <span class="category-link">Open original article</span>
        </a>
      </div>
      
      <hr />

      <a
        v-if="!showComments"
        href="#"
        @click.prevent="loadComments()"
        style="text-decoration: none; color: #222222"
      >
        <div class="login-button">
          <span>Show comments</span>
        </div>
      </a>

      <div v-if="showComments">
        <img
          v-if="showComments && comments == null"
          src="/src/assets/loading-comments.svg"
          alt="Loading"
          style="width: 32px; height: 32px"
        />

        <form
          v-if="showComments && (comments != null || commentsMessage != null) && userDetails.loggedIn" class="flex-col" @submit.prevent="postComment(replyTo != null)">
          <div v-if="replyTo != null" class="comment-reply-block" style="width: var(--comment-width)">
            <p class="comment-reply-title">
              Replying to comment by
              <span class="comment-reply-user">{{ comments[replyTo].reply.username }}</span>
            </p>

            <p class="comment-reply-content">{{ comments[replyTo].reply.content }}</p>
            <a href="#" style="text-decoration: none; color: #be3a4e" @click.prevent="replyTo = null">Cancel reply</a>
          </div>

          <label for="comment"></label>
          <textarea
            id="comment"
            name="comment"
            class="login-input"
            v-model="commentContent">
          </textarea>
          <span>Commenting as <strong>{{ userDetails.user }}</strong></span>
          <input class="login-submit" type="submit" value="Post comment" />
        </form>

        <div v-if="!userDetails.loggedIn || userDetails.loggedIn == null" style="width: fit-content; margin: 1rem auto">
          <h2>You must login to write a comment</h2>
          <router-link :to="{ name: 'Login' }" style="text-decoration: none; color: #222"><div class="login-button">Log In</div></router-link>
          <p>or</p>
          <router-link :to="{ name: 'Register' }" style="text-decoration: none; color: #222"><div class="login-button">Register</div></router-link>
        </div>

        <h3 v-if="commentsMessage != null">{{ commentsMessage }}</h3>

        <div v-if="comments.length > 0">
          <Comment
            v-for="i in comments.length"
            :comment="comments[i - 1]"
            :cid="i - 1"
            :mod="userDetails.isAdmin ?? false"
            @set-reply-to="setReplyTo"
            @set-deleted="setCommentDeleted"
          />
        </div>
        <h3 v-else-if="commentsMessage == null">
          This article doesn't have any comments yet!
        </h3>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Comment from "../components/Comment.vue";

export default {
  name: "ReadArticle",
  components: { Comment },
  data() {
    return {
      article: null,
      message: null,
      rating: {
        likes: 0,
        dislikes: 0,
      },
      showComments: false,
      comments: null,
      commentsMessage: null,
      replyTo: null,
      commentContent: "",
      userDetails: null,
      imageData: null,
    };
  },
  props: {
    slug: {
      required: true,
      type: String,
    },
  },
  async created() {
    await axios
      .post("/api/getArticles.php", {
        type: "slug",
        slug: this.slug,
      })
      .then((response) => response.data)
      .then((json) => {
        if (json.success) {
          this.article = json.article;
          this.rating.likes = json.article.likes
          this.rating.dislikes = json.article.dislikes
          this.getModAccess();
          this.getImage();
        } else this.message = json.message;
      });
  },
  methods: {
    async rateArticle(liked = true) {
      await axios
        .post("/api/rate.php", {
          article: this.article.id,
          liked: liked,
        })
        .then((response) => response.data)
        .then((json) => {
          if (json.success) {
            this.rating.likes = json[0][0].likes
            this.rating.dislikes = json[0][0].dislikes
          }
          else this.message = json.message;
        });
    },
    async getRatings() {
      await axios
        .post("/api/rate.php", {
          article: this.article.id,
        })
        .then((response) => response.data)
        .then((json) => {
          if (json.success) this.rating = json.stats;
        });
    },
    async loadComments() {
      this.showComments = true;

      await axios
        .post("/api/comment.php", {
          action: "get",
          article: this.article.id,
        })
        .then((response) => response.data)
        .then((json) => {
          if (json.success) this.comments = json.comments;
          else this.commentsMessage = json.message;
        });
    },
    async postComment(isReply = false) {
      this.commentsMessage = null;

      let data = {
        action: "post",
        article: this.article.id,
        content: this.commentContent,
      };
      if (isReply) data.main = this.comments[this.replyTo].reply.cid;

      await axios
        .post("/api/comment.php", data)
        .then((response) => response.data)
        .then((json) => {
          if (json.success) this.comments = json.comments;
          else this.commentsMessage = json.message;
        });
    },
    setReplyTo(event) {
      console.log(event);
      this.replyTo = event;
    },
    async getModAccess() {
      await axios
        .post("/api/details.php", { request: "get_details" })
        .then((response) => response.data)
        .then((json) => {
          this.userDetails = json;
        });
    },
    async setCommentDeleted(event) {
      await axios
        .post("/api/comment.php", {
          action: "delete",
          comment: this.comments[event].reply.cid,
        })
        .then((response) => response.data)
        .then((json) => {
          if (json.success) this.comments = json.comments;
        });
    },
    async getImage() {
      await axios.get('/api/article-img.php?id=' + this.slug).then(response => response.data).then(json => {
        if (json.success) {
          if (json.data != 'none') {
            let img = json.data
            if (img.includes('.png') || img.includes('.jpg') || img.includes('.gif') || img.includes('.webp')) {
              this.imageData = '/images/' + json.data
            } else {
              this.imageData = '/images/' + json.data + '.png'
            }
          } else {
            this.imageData = "/src/demo/photo.jpg"
          }
        } else {
          this.imageData = false
        }
      })
    }
  },
};
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
  transition: all 0.25s;
  padding: 8px;
  border-radius: 8px;
  cursor: pointer;
}

.action-button:hover {
  transform: scale(110%);
  background: #fac898;
}

.action-icon {
  height: 1.5rem;
  aspect-ratio: 1;
  margin-right: 8px;
  filter: var(--icon-color);
}

.article-block {
  width: clamp(256px, 92%, 1024px);
  margin: 0 auto;
}

.article-text {
  text-align: justify;
}

.login-input {
  width: var(--comment-width);
  margin: 8px auto;
}

.login-submit {
  margin: 8px auto;
}

.image-skeleton {
  border-radius: 8px;
  max-width: 60%;
  aspect-ratio: 16/9;
  margin: 1rem auto 0;
  animation: pulse 1s infinite alternate linear;
}

.article-image {
  margin: 1rem auto 0;
  max-width: 80%;
  max-height: 320px;
  object-fit: contain;
}

.category-link {
  color: #42b983;
  font-size: 1.25rem;
  transition: all 0.2s;
}

.category-link:hover {
  color: #308060;
  text-decoration: underline 1px #308060;
}

.article-author {
  font-weight: bold;
  color: var(--input-border);
}

.article-author:hover {
  text-decoration: underline 1px var(--input-border);
}

.article-summary {
  font-weight: bold;
  font-size: 1.1rem;
  text-align: justify;
}
</style>
