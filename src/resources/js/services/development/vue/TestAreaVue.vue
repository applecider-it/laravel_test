<script setup lang="ts">
/** vueテスト用コンポーネント */

import { ref } from "vue";

import { showToast, setIsLoading } from "@/services/ui/message";

import type ProgressClient from "@/services/ui/ProgressClient";
import type SampleJobClient from "../SampleJobClient";

import SlowJobArea from "./test-area-vue/SlowJobArea.vue";
import ModalArea from "./test-area-vue/ModalArea.vue";
import LaravelEchoArea from "./test-area-vue/LaravelEchoArea.vue";
import DefineModelArea from "./test-area-vue/DefineModelArea.vue";

console.log("draw");

interface Props {
    testValue?: number;
    progressClient: ProgressClient;
    sampleJobClient: SampleJobClient;
}

const props = defineProps<Props>();

// もしpropsをreactive にしたい場合
const testValue = ref(props.testValue ?? 0);

const cnt = ref<number>(0);

/** refの動作確認 */
function increment() {
    // 連続して追加して値が反映されるかの確認（reactだと反映されない）
    testValue.value++;
    testValue.value++;

    console.log(testValue.value);
}

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
    <div class="py-6 border-gray-500 border-2 p-5">
        <div class="mb-6 text-lg">vue.js動作確認</div>
        <p>testValue: {{ testValue }}</p>
        <button @click="increment" class="app-btn-orange">増やす</button>

        <div class="mt-5">
            <div class="mt-5">
                <button class="app-btn-secondary mr-2" @click="loadingTest">
                    Loading
                </button>
            </div>

            <div class="mt-5 space-x-2">
                <button
                    class="app-btn-primary"
                    @click="() => toastTest('notice')"
                >
                    Toast notice
                </button>
                <button
                    class="app-btn-primary"
                    @click="() => toastTest('alert')"
                >
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

        <div class="mt-5">
            <DefineModelArea />
        </div>

        <div class="mt-5">
            <LaravelEchoArea />
        </div>

        <div class="mt-5">
            <SlowJobArea
                :sampleJobClient="sampleJobClient"
                :progressClient="progressClient"
            />
        </div>

        <div class="mt-5">
            <ModalArea />
        </div>
    </div>
</template>
