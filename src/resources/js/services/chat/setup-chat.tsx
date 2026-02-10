/**
 * チャットのセットアップ
 */

import React from "react";
import { createRoot } from "react-dom/client";
import ChatArea from "./react/ChatArea";

import ChatClient from "./ChatClient";

const el: any = document.getElementById("chat-root");

if (el) {
    const all = JSON.parse(el.dataset.all);

    console.log('all', all);

    const chatClient = new ChatClient(all.token, all.wsHost, all.room);

    const root = createRoot(el);
    root.render(<ChatArea chatClient={chatClient} />);
}
