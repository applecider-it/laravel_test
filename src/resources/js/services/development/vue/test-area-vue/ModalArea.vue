<script setup lang="ts">
/** モーダルウィンドウ動作確認 */

import { ref } from "vue";

import Modal from "@/services/ui/vue/popup/Modal.vue";

const open = ref<boolean>(false);
const modalValue = ref<string>("");

/** モーダルウィンドウの値の確認 */
const confirmModalValue = () => {
    alert(modalValue.value);
};
</script>

<template>
    <div>
        モーダルウィンドウ動作確認

        <div class="mt-5 space-y-2">
            <div class="space-x-2">
                <button
                    class="app-btn-orange"
                    @click="() => {open = true}"
                >
                    モーダルウィンドウ
                </button>
                <button
                    @click="confirmModalValue"
                    class="app-btn-secondary"
                >
                    確認
                </button>
            </div>
            <div>modalValue: {{ modalValue }}</div>
        </div>
    </div>

    <Modal :isOpen="open" :onClose="() => {open = false;}"">
        <h2 className="text-xl font-bold mb-2">モーダルタイトル</h2>

        <div className="my-4">
            <textarea
                rows="3"
                cols="40"
                className="w-full border rounded p-2"
                placeholder="What's happening?"
                v-model="modalValue"
            />
        </div>

        <button
            @click="() => {open = false}"
            className="app-btn-secondary"
        >
            閉じる
        </button>
    </Modal>

</template>
