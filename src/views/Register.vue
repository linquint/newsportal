<template>
  <div class="view">
    <h1>Register</h1>

    <form @submit.prevent="register()" class="login-form">
      <label for="username" class="login-label">Username <span class="login-required">*</span></label>
      <input type="text" id="username" name="username" class="login-input" minlength="4" maxlength="32" v-model="details.username">
      <div class="login-error" :class="correctLength('username')">Must be 4-32 characters long</div>

      <label for="email" class="login-label">Email <span class="login-required">*</span></label>
      <input type="email" id="email" name="email" class="login-input" v-model="details.email">

      <label for="password" class="login-label">Password <span class="login-required">*</span></label>
      <input type="password" id="password" name="password" class="login-input" minlength="8" maxlength="64" v-model="details.password">
      <div class="login-error" :class="correctLength('password')" style="transform: translateY(240px)">Must be 8-64 characters long</div>

      <label for="confirm-password" class="login-label">Confirm password <span class="login-required">*</span></label>
      <input type="password" id="confirm-password" name="confirm-password" class="login-input" minlength="8" maxlength="64" v-model="details.confPassword">
      <div class="login-error" :class="correctLength('confpassword')" style="transform: translateY(328px)">Must be 8-64 characters long</div>
      <div class="login-error" :class="correctLength('confpassword') && details.password === details.confPassword ? 'login-correct' : null" style="transform: translateY(346px)">Passwords need to match</div>

      <button type="submit" class="login-submit" name="login" value="Register">Register</button>
      {{ message }}
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "Register",
  data() {
    return {
      details: {
        username: '',
        email: '',
        password: '',
        confPassword: ''
      },
      message: null,
    }
  },
  methods: {
    correctLength(input) {
      switch (input) {
        case 'username': return (this.details.username.length < 33 && 3 < this.details.username.length) ? 'login-correct' : null
        case 'password': return (this.details.password.length < 65 && 7 < this.details.password.length) ? 'login-correct' : null
        case 'confpassword': return (this.details.confPassword.length < 65 && 7 < this.details.confPassword.length) ? 'login-correct' : null
      }
    },
    async register() {
      await axios.post('/api/register.php', {
        "username": this.details.username,
        "password": this.details.password,
        "passwordConfirm": this.details.confPassword,
        "email": this.details.email
      }).then(response => {
        console.log(JSON.stringify(response))
        return response.data
      }).then(async json => {
        console.log(JSON.stringify(JSON))

        if (json.success) {
          await this.$router.push({name: 'Account'})
        } else {
          this.message = json.message
        }
      })
    }
  }
}
</script>

<style scoped>
.login-required {
  color: red;
  font-weight: bold;
}

.login-error {
  display: none;
  color: red;
  font-size: 13px;
  position: absolute;
  transform: translateY(64px);
}

.login-input:focus + .login-error, .login-input:focus + .login-error + .login-error {
  display: initial;
}

.login-correct {
  color: #42b983;
}
</style>