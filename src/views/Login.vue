<template>
  <div class="view">
    <h1>Prisijungti</h1>
    <form class="login-form" @submit.prevent>
      <label for="username" class="login-label">Prisijungimo vardas</label>
      <input type="text" id="username" name="username" class="login-input">

      <label for="password" class="login-label">Slaptažodis</label>
      <input type="text" id="password" name="password" class="login-input">

      <input type="submit" class="login-submit" name="login" value="Prisijungti">
    </form>
  </div>
</template>

<script>
export default {
  name: "Login"
}
</script>

<style scoped>

</style>