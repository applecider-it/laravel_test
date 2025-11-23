<template>
  <input v-model="model" class="app-form-input" />
</template>

<script setup lang="ts">
const model = defineModel<string>({ default: "" }) // 型とデフォルト値を指定
</script>
