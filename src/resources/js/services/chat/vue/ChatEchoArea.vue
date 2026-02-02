<script lang="ts">
import { defineComponent } from "vue";
import ChatClient from "../ChatEchoClient";

export default defineComponent({
    name: "ChatEchoArea",

    props: {
        chatClient: {
            type: Object as () => ChatClient,
            required: true,
        },
    },

    data() {
        return {
            message: "" as string,
            messageList: [] as any[],
            userList: [] as any[],
        };
    },

    mounted() {
        // Echoからのメッセージ受信
        this.chatClient.addMessage = (row: any) => {
            this.messageList = [row, ...this.messageList];
        };

        // 接続ユーザー一覧更新
        this.chatClient.setUsers = (users: any[]) => {
            console.log("users", users);
            this.userList = [...users];
        };
    },

    methods: {
        /** メッセージ送信 */
        sendMessage(options: any = []) {
            console.log(this.message);
            this.chatClient.sendMessage(this.message, options);
            this.message = "";
        },

        /** Enterキー送信 */
        handleKeyDown(e: KeyboardEvent) {
            if (e.key === "Enter") {
                this.sendMessage();
            }
        },
    },
});
</script>

<template>
    <div class="max-w-2xl mx-auto py-6">
        <!-- 入力エリア -->
        <div>
            <input
                type="text"
                class="border p-1 mr-2 w-80"
                v-model="message"
                @keydown="handleKeyDown"
            />

            <button
                class="p-1 border bg-gray-200 ml-2"
                @click="sendMessage()"
            >
                Send (E)
            </button>

            <button
                class="p-1 border bg-gray-200 ml-2"
                @click="sendMessage({ others: true })"
            >
                Send (E,O)
            </button>
        </div>

        <!-- メッセージ一覧 -->
        <div class="border border-gray-700 p-2 mb-2 h-80 mt-5 overflow-y-auto">
            <p v-for="(data, index) in messageList" :key="index">
                {{ data.data.message }}
                <span class="ml-2 text-sm text-gray-400">
                    by {{ data.data.name }}
                </span>
            </p>
        </div>

        <!-- 接続ユーザー一覧 -->
        <div class="mt-5">
            接続ユーザー一覧
            <div
                class="border-2 border-gray-300 p-2 mb-2 h-40 mt-2 overflow-y-auto"
            >
                <p v-for="(user, index) in userList" :key="index">
                    {{ user.id }} {{ user.name }}
                </p>
            </div>
        </div>
    </div>
</template>
