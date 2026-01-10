<script setup lang="ts">
/** vueテスト用コンポーネント */

import { ref } from "vue";

import MyForm from "./MyForm.vue";

const title = ref<string>("");
const content = ref<string>("");
</script>

<template>
    <div>
        defineModel動作確認

        <div class="mt-5">
            <p>title: {{ title }}</p>
            <p>content: {{ content }}</p>

            <MyForm v-model:title="title" v-model:content="content" />
        </div>
    </div>
</template>
