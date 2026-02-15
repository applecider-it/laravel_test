<script setup lang="ts">
/** Form動作確認 */

import { ref } from "vue";

const listVal = ref(2);
const radioVal = ref("val1");
const dateTimeVal = ref("2026-02-15T14:30");

const listVals = ref([
    { value: 1, label: "No. 1" },
    { value: 2, label: "No. 2" },
    { value: 3, label: "No. 3" },
]);

const radioVals = ref([
    { value: "val1", label: "Value 1" },
    { value: "val2", label: "Value 2" },
]);
</script>

<template>
    <div>
        Form動作確認

        <div class="mt-5">
            <label for="listVal" class="app-form-label">リスト動作確認</label>
            <select v-model="listVal" id="listVal">
                <option disabled value="">選択してください</option>
                <option
                    v-for="item in listVals"
                    :key="item.value"
                    :value="item.value"
                >
                    {{ item.label }}
                </option>
            </select>

            <p>選択中: {{ listVal }}</p>
        </div>

        <div class="mt-5">
            <label class="app-form-label">ラジオボタン動作確認</label>
            <div class="space-x-3">
                <label v-for="item in radioVals" :key="item.value">
                    <input
                        type="radio"
                        :value="item.value"
                        v-model="radioVal"
                    />
                    {{ item.label }}
                </label>
            </div>

            <p>選択中: {{ radioVal }}</p>
        </div>

        <div class="mt-5">
            <label for="dateTimeVal" class="app-form-label">日時動作確認</label>
            <input type="datetime-local" v-model="dateTimeVal" id="dateTimeVal" />

            <p>選択中: {{ dateTimeVal }}</p>
        </div>
    </div>
</template>
