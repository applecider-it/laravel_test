/**
 * チャットのセットアップ
 */

import React from "react";
import { createRoot } from "react-dom/client";
import Chat from "./Chat";

import ChatClient from "./ChatClient";

const el: any = document.getElementById("chat-root");

if (el) {
    const all = JSON.parse(el.dataset.all);

    const chatClient = new ChatClient(all.token, all.wsHost);

    const root = createRoot(el);
    root.render(<Chat chatClient={chatClient} />);
}
