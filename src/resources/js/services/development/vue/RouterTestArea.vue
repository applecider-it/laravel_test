<template>
  <div class="text-lg">router動作確認</div>

  <div>タグからの値: {{ name }}</div>

  <div class="mt-5 space-x-2">
    <router-link to="/" class="app-link-normal" active-class="app-link-active"
      >Page1</router-link
    >
    <router-link
      to="/page2/123"
      class="app-link-normal"
      active-class="app-link-active"
      >Page2</router-link
    >
  </div>

  <div class="mt-5 py-6 border-gray-500 border-2 p-5">
    <router-view />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';

interface Props {
  name: string;
}

const props = defineProps<Props>();

// 初期化時
onMounted(() => {
  console.log('router test mounted');
});
</script>
