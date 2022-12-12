<template>
    <div class="author-info">
        <div class="author-header">
            <img class="author-image" :src="photo" :alt="'Profile image: ' + name">
            <div class="flex-col" style="justify-content: center;">
                <span class="author-name">{{ name }}</span>
                <span class="author-username">@<span>{{ username }}</span></span>
                <span class="author-date-since">Author since <span>{{ since }}</span></span>
            </div>
        </div>
        <span style="text-align: left; margin: 1rem 0 0.25rem; display: block; font-weight: bold; font-size: 1.25em;">About me</span>
        <span class="author-about" v-if="about != null && about.length > 0">{{ about }}</span>
        <span class="author-about" v-else>Hi! My name is {{ name }} and welcome to my Author profile.</span>
    </div>
</template>

<script>
export default {
    props: ['name', 'username', 'since', 'photo', 'about', 'isActive']
}
</script>