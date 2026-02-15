<script setup lang="ts">
/** vueテスト用コンポーネント */

import type ProgressClient from "@/services/ui/ProgressClient";
import type SampleJobClient from "../SampleJobClient";

import SlowJobArea from "./test-area-vue/SlowJobArea.vue";
import ModalArea from "./test-area-vue/ModalArea.vue";
import LaravelEchoArea from "./test-area-vue/LaravelEchoArea.vue";
import DefineModelArea from "./test-area-vue/DefineModelArea.vue";
import OptionsModelArea from "./test-area-vue/OptionsModelArea.vue";
import UIArea from "./test-area-vue/UIArea.vue";
import RefArea from "./test-area-vue/RefArea.vue";
import FormArea from "./test-area-vue/FormArea.vue";

interface Props {
    testValue?: number;
    progressClient: ProgressClient;
    sampleJobClient: SampleJobClient;
}

const props = defineProps<Props>();
</script>

<template>
    <div class="py-6 border-gray-500 border-2 p-5">
        <div class="mb-6 text-lg">vue.js動作確認</div>

        <div class="space-y-3">
            <div>
                <RefArea :testValue="testValue" />
            </div>

            <div>
                <UIArea />
            </div>

            <div>
                <DefineModelArea />
            </div>

            <div>
                <OptionsModelArea />
            </div>

            <div>
                <LaravelEchoArea />
            </div>

            <div>
                <SlowJobArea
                    :sampleJobClient="sampleJobClient"
                    :progressClient="progressClient"
                />
            </div>

            <div>
                <ModalArea />
            </div>

            <div>
                <FormArea />
            </div>
        </div>
    </div>
</template>
