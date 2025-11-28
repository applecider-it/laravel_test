<template>
    <div>title</div>
    <input v-model="title" class="app-form-input" />
    <div class="mt-2">content</div>
    <textarea v-model="content" class="app-form-input"></textarea>
</template>

<script setup lang="ts">
const title = defineModel<string>("title");
const content = defineModel<string>("content");
</script>
