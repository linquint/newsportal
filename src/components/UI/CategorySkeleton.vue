<template>
    <div class="category-block">
        <div class="category-skeleton-title" />
        <div class="category-skeleton-count" />
    </div>
</template>

<style scoped>
.category-skeleton-title {
  width: calc(100% - 3.75rem);
  height: calc(1.5rem + 2px);
  margin: auto 0.5rem auto 0;
  animation: pulse 1s infinite alternate linear;
}

.category-skeleton-count {
  width: 3.25rem;
  height: 3.25rem;
  border-radius: 8px;
  animation: pulse 1s infinite alternate linear;
}
</style>