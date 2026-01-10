<script setup lang="ts">
/** UI動作確認 */

import { ref } from "vue";

import { showToast, setIsLoading } from "@/services/ui/message";

const cnt = ref<number>(0);

/** ロード画面の動作確認 */
const loadingTest = () => {
    console.log("Loading vue.js");
    setIsLoading(true);
    setTimeout(() => {
        setIsLoading(false);
    }, 2000);
};

/** トーストの動作確認 */
const toastTest = (type) => {
    cnt.value++;
    const msg = `トーストテスト vue.js type:${type} cnt.value:${cnt.value}`;
    console.log(msg);
    showToast(msg, type);
};
</script>

<template>
    <div>
        UI動作確認

        <div class="mt-5">
            <button class="app-btn-secondary mr-2" @click="loadingTest">
                Loading
            </button>
        </div>

        <div class="mt-5 space-x-2">
            <button class="app-btn-primary" @click="() => toastTest('notice')">
                Toast notice
            </button>
            <button class="app-btn-primary" @click="() => toastTest('alert')">
                Toast alert
            </button>
            <button
                class="app-btn-primary"
                @click="
                    () => {
                        toastTest('notice');
                        toastTest('alert');
                    }
                "
            >
                Toast 2
            </button>
            <span>cnt: {{ cnt }}</span>
        </div>
    </div>
</template>
