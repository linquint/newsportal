<template>
  <div :style="'height: ' + height + 'px; background-color: ' + color + '; width: ' + width + '; border-radius: ' + Math.ceil(height / 4) + 'px; margin: 8px auto'" />
</template>

<script>
export default {
  name: "divideh",
  props: {
    height: {
      required: false,
      default: 2,
      type: Number
    },
    color: {
      required: false,
      default: '#000',
      type: String
    },
    width: {
      required: false,
      default: '100%',
      type: String
    }
  }
}
</script>

<style scoped>

</style>