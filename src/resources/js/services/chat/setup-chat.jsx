/**
 * チャットのセットアップ
 */

import React from "react";
import { createRoot } from "react-dom/client";
import Chat from "./Chat.jsx";

import ChatWebSocketClient from "./ChatWebSocketClient";

const el = document.getElementById("chat-root");

if (el) {
    const all = JSON.parse(el.dataset.all);

    const chatClient = new ChatWebSocketClient(all.token, all.wsHost);

    const root = createRoot(el);
    root.render(<Chat chatClient={chatClient} />);
}
