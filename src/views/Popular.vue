<template>
    <div class="view">
        <h1>Most active <span class="highlight">authors</span></h1>
        <div class="data-grid">
            <AuthorActivity v-for="i in count * 3" :name="active_authors[i - 1].name" :handle="active_authors[i - 1].username" :articles="active_authors[i - 1].count" />
        </div>

        <h1>Most reoccurring <span class="highlight">categories</span></h1>
        <div class="data-grid">
            <Category v-for="i in ((count * 2 < categories.length) ? count * 2 : categories.length)" :title="categories[i - 1].title" :count="categories[i - 1].count" />
        </div>

        <h1>Most popular <span class="highlight">regions</span></h1>
        <div class="data-grid">
            <Region v-for="i in ((count * 2 < regions.length) ? count * 2 : regions.length)" :title="regions[i - 1].region" :count="regions[i - 1].count" />
        </div>

        <h1>Hottest <span class="highlight">articles</span> this week</h1>
        <div class="data-grid">
            <Article v-for="i in ((count * 3 < hottest.length) ? count * 3 : hottest.length)" :data="hottest[i-1]" />
        </div>

        <h1>Controversial <span class="highlight">articles</span></h1>
        <div class="data-grid">
            <Article v-for="i in ((count * 3 < controversial.length) ? count * 3 : controversial.length)" :data="controversial[i-1]" />
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import AuthorActivity from '../components/AuthorActivity.vue';
import Category from '../components/Category.vue';
import Region from '../components/Region.vue';
import Article from '../components/Article.vue';

export default {
    components: { AuthorActivity, Category, Region, Article },
    data() {
        return {
            active_authors: [],
            categories: [],
            regions: [],
            hottest: [],
            controversial: [],
            count: 4,
            windowWidth: window.innerWidth
        }
    },
    async created() {
        await axios.get('/api/popular.php?count=12').then(r => r.data).then(json => {
            if (json.success) {
                this.active_authors = json.active_authors
                this.categories = json.categories
                this.regions = json.regions
                this.hottest = json.hottest
                this.controversial = json.controversial
            }
        })

        this.count = parseInt(window.getComputedStyle(document.getElementsByClassName("data-grid")[0],null).getPropertyValue("--data-count"));
        this.$watch('windowWidth', () => {
            this.count = parseInt(window.getComputedStyle(document.getElementsByClassName("data-grid")[0],null).getPropertyValue("--data-count"));
        });
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
    },
    beforeUnmount() {
        window.removeEventListener("resize", this.onResize);
    },
}
</script>

<style scoped>
.data-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(256px, 1fr));
    gap: 1em;
    --data-count: 4;
}

@media (max-width: 1339px) {
    .data-grid {
        --data-count: 3;
    }
}
@media (max-width: 1004px) {
    .data-grid {
        --data-count: 2;
    }
}
@media (max-width: 669px) {
    .data-grid {
        --data-count: 1;
    }
}
</style>