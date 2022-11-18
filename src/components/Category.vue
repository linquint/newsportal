<template>
    <div class="category-block">
        <span class="category-title">{{ title }}</span>
        <div class="category-count-box">
            <span>{{ count }}</span>
            <span v-if="count > 1">articles</span>
            <span v-else>article</span>
        </div>
    </div>
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
.category-title {
  width: calc(100% - 3.75rem);
  font-size: 1.5rem;
  text-align: left;
  margin: auto 0.5rem auto 0;
}

.category-count-box {
  width: 3.25rem;
  height: 3.25rem;
  border-radius: 8px;
  background-color: blanchedalmond;
  display: flex;
  flex-direction: column;
}

.category-count-box span:first-child {
    font-size: 1.5rem;
    text-align: center;
    display: block;
}

.category-count-box span:last-child {
    font-size: 0.75rem;
}
</style>