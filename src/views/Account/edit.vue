<template>
  <div class="wa-form">
    <h2>Edit user profile</h2>
    <div class="flex-col">
      <form @submit.prevent="changeEmail()" class="flex-col">
        <p class="edit-title">Change your email</p>
        <label for="email" class="wa-label">Email</label>
        <input type="email" id="email" class="wa-input" v-model="email.newEmail">
        <input type="submit" class="login-submit" value="Change email">
        {{ messageEmail }}
      </form>

      <divideh height=3 />

      <form @submit.prevent="changePassword()" class="flex-col">
        <p class="edit-title">Change your password</p>
        <p class="wa-field-note">Password must be at least 8 characters long</p>
        <label for="currentPassword" class="wa-label">Current password</label>
        <input type="password" id="currentPassword" class="wa-input" v-model="password.currentPassword">

        <label for="newPassword" class="wa-label">New password</label>
        <input type="password" id="newPassword" class="wa-input" v-model="password.newPassword">

        <label for="confirmPassword" class="wa-label">Confirm new password</label>
        <input type="password" id="confirmPassword" class="wa-input" v-model="password.confirmPassword">
        <input type="submit" class="login-submit" value="Change password">
        {{ messagePassword }}
      </form>

      <divideh height=3 />

      <form @submit.prevent class="flex-col">
        <p class="edit-title">Change your profile picture</p>
        <label for="image" class="wa-label">Upload profile picture</label>
        <input type="file" id="image" class="wa-input">
        <input type="submit" class="login-submit" value="Change picture">
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import divideh from "../../components/UI/divideh.vue";

export default {
  name: "edit",
  components: {divideh},
  data() {
    return {
      email: {
        newEmail: ''
      },
      password: {
        currentPassword: '',
        newPassword: '',
        confirmPassword: ''
      },
      messageEmail: null,
      messagePassword: null,
    }
  },
  methods: {
    async changeEmail() {
      this.messageEmail = null
      await axios.post('/api/edit-profile.php', {
        type: "email",
        userdata: this.email
      }).then(response => response.data).then(json => {
        if (json.success) this.messageEmail = 'Email changed successfully'
        else this.messageEmail = json.message
      })
    },
    async changePassword() {
      this.messagePassword = null
      await axios.post('/api/edit-profile.php', {
        type: "password",
        userdata: this.password
      }).then(response => response.data).then(json => {
        if (json.success) this.messagePassword = 'Password changed successfully'
        else this.messagePassword = json.message
      })
    }
  }
}
</script>

<style scoped>
  .edit-title {
    margin: 8px auto;
    text-align: left;
    font-weight: bold;
    font-size: 1.25rem;
    color: var(--text-color-light);
  }
</style>