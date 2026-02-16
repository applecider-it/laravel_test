<script setup lang="ts">
/** vueテスト用コンポーネント */

import type ProgressClient from "@/services/ui/ProgressClient";
import type SampleJobClient from "../SampleJobClient";

import SlowJobArea from "./test-websocket-area-vue/SlowJobArea.vue";
import LaravelEchoArea from "./test-websocket-area-vue/LaravelEchoArea.vue";

interface Props {
    progressClient: ProgressClient;
    sampleJobClient: SampleJobClient;
}

const props = defineProps<Props>();

const blockStyle = "border-gray-400 border-2 p-3";
</script>

<template>
    <div class="py-6 border-gray-500 border-2 p-5">
        <div class="mb-6 text-lg">vue.js動作確認</div>

        <div class="space-y-4">
            <div :class="blockStyle">
                <LaravelEchoArea />
            </div>

            <div :class="blockStyle">
                <SlowJobArea
                    :sampleJobClient="sampleJobClient"
                    :progressClient="progressClient"
                />
            </div>
        </div>
    </div>
</template>
