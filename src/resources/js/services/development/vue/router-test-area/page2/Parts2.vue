<template>
  <h3 class="text-xl">Page2 Parts2</h3>

  <div class="space-y-2 mt-5">
    <div>
      <button @click="cnt++" class="app-btn-primary">Add</button>
    </div>
    <div>
      <button @click="commonCnt++" class="app-btn-primary">Add Common</button>
    </div>
    <div>
      <button @click="back" class="app-btn-primary">Back</button>
    </div>
    <div>
      <span>cnt: {{ cnt }}</span>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const commonCnt = defineModel<number>('commonCnt');

const cnt = ref<number>(0);

const back = () => {
  router.push('/');
};

// 初期化時
onMounted(() => {
  console.log('parts2 mounted');
});
</script>
