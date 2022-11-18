<template>
  <div class="comment-block">
    <div class="flex-row">
      <img src="/src/assets/icons/technology.png" alt="pfp" class="comment-profile-picture">
      <div class="flex-col">
        <span class="comment-user">{{ comment.reply.username }}</span>
        <span class="comment-date">{{ comment.reply.post_date }}</span>
      </div>
    </div>

    <div v-if="comment.main != null" class="comment-reply-block">
      <p class="comment-reply-title">Reply to comment by <span class="comment-reply-user">{{ comment.main.username }} </span>({{ comment.main.post_date }})</p>
      <p v-if="comment.main.deleted" class="comment-reply-content deleted">[ deleted ]</p>
      <p v-else class="comment-reply-content">{{ comment.main.content }}</p>
    </div>

    <p v-if="comment.reply.deleted" style="text-align: left; margin: 8px auto; width: 100%;" class="deleted">[ deleted ]</p>
    <p v-else style="text-align: left; margin: 8px auto; width: 100%;">{{ comment.reply.content }}</p>

    <div class="flex-row" style="justify-content: space-between">
      <a v-if="!comment.reply.deleted" href="#" style="text-decoration: none; color: #444;" @click.prevent="$emit('setReplyTo', cid)">
        <div class="comment-reply">
          <img src="/src/assets/icons/reply.png" alt="Reply" style="height: 19px; aspect-ratio: 1">
          <span style="margin-left: 8px;">Reply</span>
        </div>
      </a>

      <a v-if="mod && !comment.reply.deleted" href="#" style="text-decoration: none; color: #444;" @click.prevent="$emit('setDeleted', cid)">
        <div class="comment-delete">
          <img src="/src/assets/icons/reply.png" alt="Reply" style="height: 19px; aspect-ratio: 1">
          <span style="margin-left: 8px;">Delete</span>
        </div>
      </a>
    </div>
  </div>
</template>

<script>

export default {
  name: "Comment",
  props: {
    comment: {
      required: true,
      type: Object
    },
    cid: { // Comment ID inside array
      required: true,
      type: Number
    },
    mod: { // is user a moderator
      required: false,
      type: Boolean|Number,
      default: false
    }
  }
}
</script>

<style scoped>
.comment-user {
  font-size: 14px;
  font-weight: bold;
  color: #333;
  text-align: left;
}

.comment-date {
  font-size: 14px;
  color: #666;
  text-align: left;
}

.comment-profile-picture {
  border-radius: 50%;
  border: 2px solid #2c3e50;
  width: 34px;
  height: 34px;
  margin: 0 8px 8px 0;
}

.comment-reply, .comment-delete {
  display: flex;
  flex-direction: row;
  padding: 4px;
  border-radius: 8px;
  width: fit-content;
  transition: all .2s;
}

.comment-reply:hover {
  background: #A0CA97;
}

.comment-delete:hover {
  background: #FAC898;
}

.deleted {
  color: #BE3A4E;
}
</style>