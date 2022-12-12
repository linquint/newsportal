<template>
    <router-link :to="'/region/' + title" class="region-container">
        <div class="article-count">
            <span>{{ count }}</span>
            <span>articles</span>
        </div>
        <span class="region-title">{{ title }}</span>
    </router-link>
</template>

<script>
export default {
    props: {
        title: {
            required: true,
            type: String
        },
        count: {
            required: true,
            type: Number
        }
    }
}
</script>

<style scoped>
a {
    display: flex;
    flex-direction: row;
    gap: 0.5em;
    border-radius: 12px;
    border: 2px solid var(--emphasis-red);
    cursor: pointer;
    text-decoration: none;
    color: var(--text-color);
}
a:hover .region-title {
    text-decoration: underline;
}
.region-title {
  font-size: 1.25em;
  text-align: left;
  align-self: center;
}

.article-count {
    display: flex;
    flex-direction: column;
    border-radius: 8px 0 0 8px;
    background-color: var(--emphasis-red);
    color: var(--nav-background);
    padding: 0.5em;
}
.article-count span:first-child {
    font-weight: bold;
    font-size: 1.25em;
}
</style>