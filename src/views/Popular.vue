<template>
    <div class="view">
        <section class="list" :style="reading && windowWidth < 721 ? 'display: none' : ''">
            <div class="select-time" @click="openSelect()" :class="selecting ? 'open' : ''" :style="loading ? 'cursor: not-allowed' : ''">
                <div class="selection" :style="selecting ? 'padding-bottom: 0.5em; border-bottom: 1px solid #800;' : ''">
                    <span :class="trending[selected].start ? 'markdown' : ''">{{ trending[selected].pre }}</span>
                    <span :class="!trending[selected].start ? 'markdown' : ''">{{ trending[selected].post }}</span>
                </div>

                <template v-if="selecting">
                    <div class="selection" v-for="i in trending.length" @click="getTrending(i - 1)">
                        <span :class="trending[i - 1].start ? 'markdown' : ''">{{ trending[i - 1].pre }}</span>
                        <span :class="!trending[i - 1].start ? 'markdown' : ''">{{ trending[i - 1].post }}</span>
                    </div>
                </template>
            </div>

            <template v-if="articles != null">
                <Article v-for="i in articles.length" :data="articles[i - 1]" prefix="/trending" @click="reading = true" />
            </template>
        </section>

        <section class="reader" v-if="(reading && windowWidth < 721) || (windowWidth > 720)">
            <div v-if="!reading" style="display: flex; flex-direction: column; height: calc(100% - 60px); justify-content: center;">
                <span style="font-size: 1.5em; font-weight: bold;">Open an article</span>
                <span>Select an article from the left side</span>
            </div>

            <div v-else><router-view /></div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';
import Article from '../components/Article.vue';

export default {
    components: { Article },
    data() {
        return {
            articles: null,
            loading: true,
            reading: false,
            windowWidth: window.innerWidth,
            selecting: false,
            selected: 0,
            trending: [
                { days: 1, pre: 'Trending past', post: '24 hours', start: false },
                { days: 7, pre: 'Trending past', post: '7 days', start: false },
                { days: 30, pre: 'Trending past', post: '30 days', start: false },
                { days: 7300, pre: 'All time', post: 'trending', start: true }
            ]
        }
    },
    async created() {
        await axios.get('/api/hot.php?count=12&days=1').then(r => r.data).then(json => {
            if (json.success) {
                this.articles = json.data
            }
        }).finally(() => this.loading = false)
    },
    methods: {
        openSelect() {
            if (!this.loading) {
                this.selecting = !this.selecting
            }
        },
        async getTrending(id) {
            this.selected = id
            this.loading = true
            this.selecting = false

            await axios.get('/api/hot.php?count=12&days=' + this.trending[id].days).then(r => r.data).then(json => {
                if (json.success) {
                    this.articles = json.data
                }
            }).finally(() => this.loading = false)
        },
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
        this.reading = this.$route.path.includes('/article/')
    },
    beforeUnmount() {
        window.removeEventListener("resize", this.onResize);
    },
    updated() {
        this.reading = this.$route.path.includes('/article/')
    }
}
</script>

<style scoped>
.select-time {
    margin: 1em;
    background: #ff8b8f;
    border-radius: 12px;
    padding: 0.8em;
    color: #333;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    font-size: 1em;
    animation: close 0.3s ease-in forwards;
}

.selection {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.selection:not(:first-child) {
    margin: 0.25em 0;
    padding: 0.25em;
}

.selection:not(:first-child):hover {
    outline: 1px solid #fff;
    border-radius: calc(12px - 0.8em / 2);
    
}

.selection > span {
    font-weight: bold;
    display: block;
    align-self: center;
}

.markdown {
    background: #800;
    color: #fff;
    padding: 0.25em 0.5em;
    border-radius: calc(12px - 0.8em / 2);
    text-align: right;
    display: block;
}

.open {
    overflow: hidden;
    animation: open 0.3s ease-out forwards;
}

@keyframes open {
    0% {
        height: 1.75em;
    }
    25% {
        height: 7.5em;
    }
    50% {
        height: 10.38em;
    }
    75% {
        height: 12.25em;
    }
    100% {
        height: 13.25em;
    }
}

@keyframes close {
    0% {
        height: 13.25em;
    }
    25% {
        height: 7.5em;
    }
    50% {
        height: 4.62em;
    }
    75% {
        height: 2.75em;
    }
    100% {
        height: 1.75em;
    }
}
</style>