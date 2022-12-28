<template>
  <div ref="mainView">
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
      article: {
        "id": 2944,
        "title": "Purdy leads 49ers past Commanders 37-20 for 8th straight win",
        "content": "SANTA CLARA, Calif. (AP) — Brock Purdy shook off a sluggish first half and did what he has done since taking over as starting quarterback for the San Francisco 49ers: He delivered big plays. Purdy threw two more long touchdown passes to George Kittle and the 49ers beat the Washington Commanders 37-20 on Saturday for their eighth straight win. “He’s just getting the ball to us,\" Kittle said. \"He’s great with the football. He puts it on target. He allows guys to run with it. He’s super savvy in the backfield, makes guys miss. \"His confidence is through the roof right now and I don’t know why it wouldn’t be.” Purdy kept up his impressive play since stepping in for the injured Jimmy Garoppolo early in Week 13, looking far better than expected for the player picked last in this year’s NFL draft. He has thrown two TD passes in four straight games for the 49ers (11-4) and won all three of his starts as San Francisco keeps the pressure on Minnesota in the race for the No. 2 seed in the NFC. Purdy joined Hall of Famer Kurt Warner as the only quarterbacks since starts began being tracked in 1950 to win his first three starts while throwing multiple touchdown passes in each game. “I don’t really think about getting more and more comfortable or anything like that,” he said. “I still have that same fire and drive as before when I wasn’t playing. I want to go in and I want to prove to my teammates and earn the respect every play, every snap, every drive.\" Taylor Heinicke threw two TD passes for Washington (7-7-1) but also lost a fumble and threw an interception in the fourth quarter. He was replaced after his second giveaway by Carson Wentz and coach Ron Rivera said he hadn't decided which quarterback will start next week. The Commanders are winless in their last three games, but still hold a half-game lead over Seattle and Detroit in the race for the final playoff spot in the NFC. “Nothing’s changed, we’re still in the same situation we were in going into this,” Rivers said. “We control our own destiny. We win the next two, we give ourselves a chance, so that’s up to us.” The Niners broke the game open in the third quarter thanks to some more big plays from Purdy. They took the opening kickoff of the second half and drove to the go-ahead score when Kittle got open deep for a 34-yard score that he stole away from the intended target, teammate Ray-Ray McCloud. Kittle scored again later in the quarter on a 33-yard catch and run to make it 21-7. Kittle also had two TD catches last week, giving him a career-high eight on the season. “He makes my job easy,” Purdy said. “He wins the man-to-man matchups with his speed and everything. You just give the dude the ball, he’ll take off.” San Francisco capitalized on big plays all game, also scoring their first touchdown on a 71-yard end around by McCloud. Nick Bosa and the Niners defense did the rest of the work with Bosa setting up one field goal by Robbie Gould with a strip-sack of Heinicke and San Francisco adding another after Jimmie Ward got an interception deep in Washington territory. Wentz, playing for the first time since Week 6, threw a 20-yard TD pass to Curtis Samuel but it was too little too late for Washington. TIP DRILL The Commanders took advantage of a couple of tipped passes to tie the game late in the first half. The first came when Purdy appeared to complete a throw over the middle to Jauan Jennings. But Jennings bobbled the ball and tipped it right to Darrick Forrest for an interception. On the ensuing drive, Washington converted a third-and-5 on a pass that Jahan Dotson bobbled before catching off a ricochet. That set up Heinicke's 4-yard TD pass to Dotson that made it 7-7 at the break. FOURTH-DOWN STOPS Both teams got stopped on fourth down in the red zone in the first half. San Francisco drove to the 15 on its first drive before Christian McCaffrey was stopped by David Mayo for no gain on a fourth-and-1 pitch from fullback Kyle Juszczyk. Washington got down to the 1 early in the second quarter when Antonio Gibson was stuffed on fourth down by Fred Warner and Javon Kinlaw. The Commanders got stopped again in the third quarter on fourth and 1 from their own 34. INJURIES Commanders: LB Jon Bostic (pectoral) left in the second half and didn't return. ... DE James Smith-Williams left in the fourth quarter to be evaluated for a head injury. 49ers: CB Charvarius Ward went to the locker room with nausea in the second half, but returned to the game. UP NEXT Commanders: Host Cleveland on Jan. 1. 49ers: Visit Las Vegas on Jan. 1. ___ AP NFL: https://apnews.com/hub/nfl and https://twitter.com/AP_NFL",
        "publish_date": "2022-12-25 16:32",
        "update_date": null,
        "summary": null,
        "region": "United States",
        "origin": "https://news.yahoo.com/purdy-leads-49ers-past-commanders-002459266.html",
        "name": "Washington Commanders",
        "likes": "0",
        "dislikes": "0",
        "categories": [],
        "comments_count": 0
      },
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
      currentSlug: '',
    };
  },
  props: {
    slug: {
      required: true,
      type: String,
    },
  },
  async created() {
    this.currentSlug = this.slug
    this.scrollToTop()
  },
  async updated() {
    if (this.currentSlug != this.slug) {
      this.currentSlug = this.slug
      await this.getArticle()
    }
  },
  methods: {
    async getArticle() {
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
      await axios.get('http://54.195.54.174/api/article-img.php?id=' + this.slug).then(response => response.data).then(json => {
        if (json.success) {
          if (json.data != 'none') {
            let img = json.data
            if (img.includes('.png') || img.includes('.jpg') || img.includes('.gif') || img.includes('.webp')) {
              this.imageData = 'http://54.195.54.174/images/' + json.data
            } else {
              this.imageData = 'http://54.195.54.174/images/' + json.data + '.png'
            }
          } else {
            this.imageData = "http://54.195.54.174/src/demo/photo.jpg"
          }
        } else {
          this.imageData = false
        }
      })
    },
    scrollToTop() {
      let { mainView } = this.$refs

      this.$nextTick(() => {
        mainView.scrollTop = 0
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
