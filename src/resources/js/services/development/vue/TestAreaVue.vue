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
    formData: any;
}

const props = defineProps<Props>();

const blockStyle = "border-gray-400 border-2 p-3";
</script>

<template>
    <div class="py-6 border-gray-500 border-2 p-5">
        <div class="mb-6 text-lg">vue.js動作確認</div>

        <div class="space-y-4">
            <div :class="blockStyle">
                <RefArea :testValue="testValue" />
            </div>

            <div :class="blockStyle">
                <UIArea />
            </div>

            <div :class="blockStyle">
                <DefineModelArea />
            </div>

            <div :class="blockStyle">
                <OptionsModelArea />
            </div>

            <div :class="blockStyle">
                <LaravelEchoArea />
            </div>

            <div :class="blockStyle">
                <SlowJobArea
                    :sampleJobClient="sampleJobClient"
                    :progressClient="progressClient"
                />
            </div>

            <div :class="blockStyle">
                <ModalArea />
            </div>

            <div :class="blockStyle">
                <FormArea
                    :list_val="formData.list_val"
                    :radio_val="formData.radio_val"
                    :datetime_val="formData.datetime_val"
                    :list_vals="formData.list_vals"
                    :radio_vals="formData.radio_vals"
                />
            </div>
        </div>
    </div>
</template>
