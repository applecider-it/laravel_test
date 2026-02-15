<script setup lang="ts">
/** Form動作確認 */

import { ref } from "vue";

interface Props {
    formData: any;
}

const props = defineProps<Props>();

const listVal = ref(props.formData.list_val);
const radioVal = ref(props.formData.radio_val);
const dateTimeVal = ref(props.formData.datetime_val);

const listVals = ref(props.formData.list_vals);

const radioVals = ref(props.formData.radio_vals);
</script>

<template>
    <div class="app-form">
        Form動作確認

        <div class="mt-5">
            <label for="listVal" class="app-form-label">リスト動作確認</label>
            <select v-model="listVal" id="listVal">
                <option disabled value="">選択してください</option>
                <option
                    v-for="(value, key) in listVals"
                    :key="key"
                    :value="key"
                >
                    {{ value }}
                </option>
            </select>

            <p>選択中: {{ listVal }}</p>
        </div>

        <div class="mt-5">
            <label class="app-form-label">ラジオボタン動作確認</label>
            <div class="space-x-3">
                <label v-for="(value, key) in radioVals" :key="key">
                    <input
                        type="radio"
                        :value="key"
                        v-model="radioVal"
                    />
                    {{ value }}
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
