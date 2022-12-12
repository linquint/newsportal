<template>
    <router-link :to="'/author/' + name" class="author-container">
        <div class="article-count">
            <span>{{ articles }}</span>
            <span>articles</span>
        </div>
        <div class="author">
            <span>{{ name }}</span>
            <span>@{{ handle }}</span>
        </div>
    </router-link>
</template>

<script>
export default {
    props: [ 'name', 'handle', 'articles' ]
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
a:hover .author span:first-child {
    text-decoration: underline;
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
.author {
    display: flex;
    flex-direction: column;
    align-self: center;
}
.author span {
    text-align: left;
}
.author span:first-child {
    font-weight: bold;
    font-size: 1em;
}
.author span:last-child {
    font-size: 0.8em;
}
</style>