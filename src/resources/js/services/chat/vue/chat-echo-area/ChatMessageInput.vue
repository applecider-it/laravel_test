<script lang="ts">
import { defineComponent } from "vue";
import { vuePropModel } from "@/services/data/html";

export default defineComponent({
    name: "ChatMessageInput",

    props: ["propMessage"],
    emits: ["update:propMessage", "send"],

    computed: {
        message: vuePropModel<string>("propMessage"),
    },

    methods: {
        /** Enterキーを押したとき */
        handleKeyDown(e: KeyboardEvent) {
            if (e.key === "Enter") {
                this.sendMessage();
            }
        },

        /** メッセージ送信 */
        sendMessage(options: any = []) {
            this.$emit("send", options);
        },
    },
});
</script>

<template>
    <input
        type="text"
        class="border p-1 mr-2 w-80"
        v-model="message"
        @keydown="handleKeyDown"
    />

    <button class="p-1 border bg-gray-200 ml-2" @click="sendMessage()">
        Send (E)
    </button>

    <button
        class="p-1 border bg-gray-200 ml-2"
        @click="sendMessage({ others: true })"
    >
        Send (E,O)
    </button>
</template>
