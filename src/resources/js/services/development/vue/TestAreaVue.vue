<template>
  <div class="py-6 border-gray-500 border-2 p-5">
    <div class="mb-6 text-lg">vue.js動作確認</div>
    <p>testValue: {{ testValue }}</p>
    <button @click="increment" class="app-btn-secondary">増やす</button>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface Props {
  testValue?: number
}

const props = defineProps<Props>()

// もし reactive にしたい場合
const testValue = ref(props.testValue ?? 0)

function increment() {
  testValue.value++
  testValue.value++
}
</script>
