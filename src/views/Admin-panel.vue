<template>
  <div class="view">
    <div v-if="admin" class="flex-row" style="margin: 16px auto;">
      <router-link :to="{ path: '/panel/authors' }" style="text-decoration: none; color: var(--text-color); margin: 0 16px;"><div class="nav-button">Manage Authors</div></router-link>
      <router-link :to="{ path: '/panel/create' }" style="text-decoration: none; color: var(--text-color); margin: 0 16px;"><div class="nav-button">Create Author</div></router-link>
    </div>

    <div v-else>
      <h2>You're not an administrator</h2>
    </div>

    <router-view v-if="admin"></router-view>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Admin-panel",
  data() {
    return {
      admin: false,
    }
  },
  async created() {
    await axios.post('/api/details.php', { 'request': 'get_access_details' }).then(response => response.data).then(json => {
      if (json.success) this.admin = json.hasAccess
    })
  }
}
</script>

<style scoped>
.cancel-button {
  border-radius: 8px;
  width: 144px;
  padding: 8px;
  margin: 16px auto;
  border: 3px solid #BE3A4E;
  background-image: linear-gradient(#BE3A4E, #BE3A4E);
  background-position: 0 50%;
  background-repeat: no-repeat;
  background-size: 0 100%;
  transition: all 0.3s linear;
}

.cancel-button:hover {
  transform: scale(115%);
  background-size: 100% 100%;
  box-shadow: 0 0 16px 4px #BE3A4Eaa;
}
</style>