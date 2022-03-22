<template>
  <div class="view">
    <div v-if="loggedIn">

    </div>

    <div v-else style="width: fit-content; margin: 64px auto 0 auto">
      <h2>Esate neprisijunge</h2>
      <router-link :to="{name: 'Login'}" style="text-decoration: none; color: #222;"><div class="login-button">Prisijungti</div></router-link>
      <p>arba</p>
      <router-link :to="{name: 'Register'}" style="text-decoration: none; color: #222;"><div class="login-button">Registruotis</div></router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: "Account",
  data() {
    return {
      loggedIn: false,
    }
  },
  created() {
    this.loggedIn = (localStorage.getItem('loggedIn') == null) ? false : localStorage.getItem('loggedIn')
  }
}
</script>

<style scoped>
.login-button {
  border-radius: 8px;
  width: 144px;
  padding: 8px;
  margin: 16px auto;
  border: 3px solid #A0CA97;
  background-image: linear-gradient(#A0CA97, #A0CA97);
  background-position: 0 50%;
  background-repeat: no-repeat;
  background-size: 0 100%;
  transition: all 0.3s linear;
}

.login-button:hover {
  transform: scale(115%);
  background-size: 100% 100%;
  box-shadow: 0 0 16px 4px #A0CA97aa;
}
</style>