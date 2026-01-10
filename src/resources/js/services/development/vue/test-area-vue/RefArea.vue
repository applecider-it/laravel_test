<script setup lang="ts">
/** Ref動作確認 */

import { ref } from "vue";

interface Props {
    testValue?: number;
}

const props = defineProps<Props>();

// もしpropsをreactive にしたい場合
const testValue = ref(props.testValue ?? 0);

/** refの動作確認 */
function increment() {
    // 連続して追加して値が反映されるかの確認（reactだと反映されない）
    testValue.value++;
    testValue.value++;

    console.log(testValue.value);
}
</script>

<template>
    <div>
        Ref動作確認

        <div class="mt-5">
            <p>testValue: {{ testValue }}</p>
            <button @click="increment" class="app-btn-orange">増やす</button>
        </div>
    </div>
</template>
