<template>
  <div class="view">
    <h1>Registruotis</h1>

    <form @submit.prevent class="login-form">
      <label for="username" class="login-label">Prisijungimo vardas <span class="login-required">*</span></label>
      <input type="text" id="username" name="username" class="login-input" minlength="4" maxlength="32" v-model="details.username">
      <div class="login-error" :class="correctLength('username')">Turi būti 4-32 simboliai</div>

      <label for="email" class="login-label">El. Paštas <span class="login-required">*</span></label>
      <input type="email" id="email" name="email" class="login-input">

      <label for="password" class="login-label">Slaptažodis <span class="login-required">*</span></label>
      <input type="password" id="password" name="password" class="login-input" minlength="8" maxlength="64" v-model="details.password">
      <div class="login-error" :class="correctLength('password')" style="transform: translateY(240px)">Turi būti 8-64 simboliai</div>

      <label for="confirm-password" class="login-label">Patvirtinti slaptažodį <span class="login-required">*</span></label>
      <input type="password" id="confirm-password" name="confirm-password" class="login-input" minlength="8" maxlength="64" v-model="details.confPassword">
      <div class="login-error" :class="correctLength('confpassword')" style="transform: translateY(328px)">Turi būti 8-64 simboliai</div>
      <div class="login-error" :class="correctLength('confpassword') && details.password === details.confPassword ? 'login-correct' : null" style="transform: translateY(346px)">Slaptažodžiai turi sutapti</div>

      <input type="submit" class="login-submit" name="login" value="Registruotis">
    </form>
  </div>
</template>

<script>
export default {
  name: "Register",
  data() {
    return {
      details: {
        username: '',
        email: '',
        password: '',
        confPassword: ''
      }
    }
  },
  methods: {
    correctLength(input) {
      switch (input) {
        case 'username': return (this.details.username.length < 33 && 3 < this.details.username.length) ? 'login-correct' : null
        case 'password': return (this.details.password.length < 65 && 7 < this.details.password.length) ? 'login-correct' : null
        case 'confpassword': return (this.details.confPassword.length < 65 && 7 < this.details.confPassword.length) ? 'login-correct' : null
      }
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