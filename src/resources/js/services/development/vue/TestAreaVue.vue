<template>
    <div class="py-6 border-gray-500 border-2 p-5">
        <div class="mb-6 text-lg">vue.js動作確認</div>
        <p>testValue: {{ testValue }}</p>
        <button @click="increment" class="app-btn-secondary">増やす</button>

        <div class="mt-3">
            <MyInput v-model="msg" />
            <p>{{ msg }}</p>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import MyInput from "./MyInput.vue";

console.log("draw");

interface Props {
    testValue?: number;
}

const props = defineProps<Props>();

// もしpropsをreactive にしたい場合
const testValue = ref(props.testValue ?? 0);

const msg = ref<string>(""); // 型指定

function increment() {
    testValue.value++;
    testValue.value++;

    console.log(testValue.value);
}
</script>
