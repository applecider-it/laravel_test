/**
 * チャットのセットアップ
 */

import { createApp } from "vue";
import ChatEchoArea from "./vue/ChatEchoArea.vue";

import ChatEchoClient from "./ChatEchoClient";

const el = document.getElementById("chat-root") as HTMLElement | null;

if (el) {
    const all = JSON.parse(el.dataset.all as string);

    const chatEchoClient = new ChatEchoClient(all.room);

    const app = createApp(ChatEchoArea, {
        chatClient: chatEchoClient,
    });

    app.mount(el);
}
