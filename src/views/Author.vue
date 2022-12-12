<template>
    <div>
        <AuthorDetailsSkeleton v-if="!isLoaded" />
        <AuthorDetails v-else :name="author" :username="username" :since="dateSince" :about="about" :photo="photo" :is-active="isActive" />

        <h2>Articles by {{ author }}</h2>
        <div class="article-list" v-if="articles != null && articlesError == null">
            <Article v-for="i in articles.length" :data="articles[i-1]" />
        </div>

        <div class="article-list" v-if="articles == null && articlesError == null">
            <ArticleSkeleton v-for="i in 12" v-if="articlesError != null" />
        </div>

        <span v-else>{{ articlesError }}</span>
    </div>
</template>

<script>
import axios from 'axios';
import Article from '../components/Article.vue';
import AuthorDetails from '../components/AuthorDetails.vue';
import ArticleSkeleton from '../components/UI/ArticleSkeleton.vue';
import AuthorDetailsSkeleton from '../components/UI/AuthorDetailsSkeleton.vue';

export default {
    data() {
        return {
            isLoaded: false,
            username: null,
            dateSince: null,
            about: null,
            photo: null,
            isActive: null,
            articles: null,
            articlesError: null,
        }
    },
    components: { AuthorDetails, ArticleSkeleton, AuthorDetailsSkeleton, Article },
    props: {
        author: {
            type: String,
            required: true
        }
    },
    async created() {
        await axios.post('/api/author-info.php', {name: this.author}).then(response => response.data).then(json => {
            if (json.success) {
                this.username = json.username
                this.dateSince = json.date_since
                this.about = json.about
                this.isActive = json.active
                this.photo = json.photo ?? '/src/potato.png'
                this.isLoaded = true

                this.getArticles()
            } else {
                this.$router.push('/404')
            }
        })
    },
    methods: {
        async getArticles() {
            await axios.post('/api/articles-by-author.php', { name: this.author }).then(response => response.data).then(json => {
                if (json.success) {
                    this.articles = json.articles
                } else {
                    this.articlesError = json.message
                }
            })
        }
    }
}
</script>

<style>
.author-info {
    width: clamp(240px, 90%, 768px);
    display: flex;
    flex-direction: column;
    margin: 80px auto 1rem;
}

.author-header {
    display: flex;
    flex-direction: row;
    gap: 1rem;
}

.author-image {
    border: 2px solid var(--input-border);
    border-radius: 8px;
    object-fit: contain;
    width: 5rem;
    height: 5rem;
    margin: auto 0;
}

.author-name {
    font-size: 2rem;
    text-align: left;
}

.author-username {
    font-size: 1rem;
    text-align: left;
    color: var(--text-color-light);
}

.author-username span {
    font-weight: bold;
    color: var(--text-color);
}

.author-date-since {
    font-size: 1rem;
    text-align: left;
    color: var(--text-color-light);
}

.author-date-since span {
    color: var(--text-color);
}

.author-about {
    text-align: justify;
    font-size: 1em;
    margin-bottom: 2rem;
}

@media (max-width: 1024px) {
    .author-image {
        width: 4rem;
        height: 4rem;
    }

    .author-name {
        font-size: 1.75rem;
    }
}

@media (max-width: 768px) {
    .author-image {
        width: 3.5rem;
        height: 3.5rem;
    }

    .author-name {
        font-size: 1.5rem;
    }

    .author-username, .author-date-since {
        font-size: 0.9rem;
    }
}

@media (max-width: 512px) {
    .author-image {
        width: 3rem;
        height: 3rem;
    }

    .author-name {
        font-size: 1.25rem;
    }

    .author-username, .author-date-since {
        font-size: 0.75rem;
    }
}

@media (max-width: 360px) {
    .author-image {
        width: 2.25rem;
        height: 2.25rem;
    }

    .author-name {
        font-size: 1rem;
    }

    .author-username, .author-date-since {
        font-size: 0.5rem;
    }
}
</style>