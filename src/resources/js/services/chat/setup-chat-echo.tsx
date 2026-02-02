/**
 * チャットのセットアップ
 */

import React from "react";
import { createRoot } from "react-dom/client";
import ChatEchoArea from "./react/ChatEchoArea";

import ChatEchoClient from "./ChatEchoClient";

const el: any = document.getElementById("chat-root");

if (el) {
    const all = JSON.parse(el.dataset.all);

    const chatEchoClient = new ChatEchoClient(all.room);

    const root = createRoot(el);
    root.render(<ChatEchoArea chatClient={chatEchoClient} />);
}
