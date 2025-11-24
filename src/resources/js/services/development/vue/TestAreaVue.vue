<template>
    <div class="py-6 border-gray-500 border-2 p-5">
        <div class="mb-6 text-lg">vue.js動作確認</div>
        <p>testValue: {{ testValue }}</p>
        <button @click="increment" class="app-btn-orange">増やす</button>

        <div class="mt-5">
            vueからreactを動かす
            <div class="mt-5">
                <button class="app-btn-secondary mr-2" @click="loadingTest">
                    Loading
                </button>
            </div>

            <div class="mt-5">
                <button
                    class="app-btn-primary mr-2"
                    @click="() => toastTest('notice')"
                >
                    Toast notice
                </button>
                <button
                    class="app-btn-primary mr-2"
                    @click="() => toastTest('alert')"
                >
                    Toast alert
                </button>
                <button
                    class="app-btn-primary mr-2"
                    @click="
                        () => {
                            toastTest('notice');
                            toastTest('alert');
                        }
                    "
                >
                    Toast 2
                </button>
                cnt: {{ cnt }}
            </div>
        </div>

        <div class="mt-3">
            defineModel動作確認
            <MyForm v-model:title="title" v-model:content="content" />

            <p>title: {{ title }}</p>
            <p>content: {{ content }}</p>
        </div>
    </div>
</template>

<script setup lang="ts">
/** vueテスト用コンポーネント */

import { ref } from "vue";
import MyForm from "./test-area-vue/MyForm.vue";
import { showToast, setIsLoading } from "@/services/ui/message";

console.log("draw");

interface Props {
    testValue?: number;
}

const props = defineProps<Props>();

// もしpropsをreactive にしたい場合
const testValue = ref(props.testValue ?? 0);

const title = ref<string>("");
const content = ref<string>("");

const cnt = ref<number>(0);

function increment() {
    testValue.value++;
    testValue.value++;

    console.log(testValue.value);
}

const loadingTest = () => {
    console.log("Loading vue.js");
    setIsLoading(true);
    setTimeout(() => {
        setIsLoading(false);
    }, 2000);
};

const toastTest = (type) => {
    cnt.value++;
    const msg = `トーストテスト vue.js type:${type} cnt.value:${cnt.value}`;
    console.log(msg);
    showToast(msg, type);
};
</script>
