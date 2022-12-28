<template>
  <div class="view">
    <section class="list" :style="action && windowWidth < 721 ? 'display: none' : ''">
      <template v-if="admin">
        <router-link :to="{ path: '/panel/authors' }" style="text-decoration: none;"><div class="account-button">Manage Authors</div></router-link>
        <router-link :to="{ path: '/panel/create' }" style="text-decoration: none;"><div class="account-button">Create Author</div></router-link>
      </template>
    </section>

    <section class="reader" v-if="(action && windowWidth < 721) || (windowWidth > 720)">
      <span v-if="!admin" class="account-container" style="font-size: 1.5em; font-weight: bold;">You do not have access to this content</span>

      <router-view v-else />
    </section>
  </div>
    <!-- <div v-if="admin" class="flex-row" style="margin: 16px auto;">
      <router-link :to="{ path: '/panel/authors' }" style="text-decoration: none; color: var(--text-color); margin: 0 16px;"><div class="nav-button">Manage Authors</div></router-link>
      <router-link :to="{ path: '/panel/create' }" style="text-decoration: none; color: var(--text-color); margin: 0 16px;"><div class="nav-button">Create Author</div></router-link>
    </div>

    <router-view /> -->
  
</template>

<script>
import axios from "axios";

export default {
  name: "Admin-panel",
  data() {
    return {
      admin: false,
      action: false,
      windowWidth: window.innerWidth,
    }
  },
  async created() {
    await axios.post('/api/details.php', { 'request': 'get_access_details' }).then(response => response.data).then(json => {
      if (json.success) this.admin = json.hasAccess
    })
  },
  methods: {
    getWidth() {
      return window.innerWidth;
    },
    onResize() {
      this.windowWidth = window.innerWidth;
    },
  },
  mounted() {
    this.$nextTick(() => {
      window.addEventListener("resize", this.onResize);
    });
    this.action = this.$route.path.includes('panel/')
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.onResize);
  },
  updated() {
    this.action = this.$route.path.includes('panel/')
  }
}
</script>