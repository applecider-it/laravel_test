import { getAuthUser } from "@/services/app/application";

import { sendMessage } from "@/services/api/rpc/chat-rpc";

/**
 * チャットクライアント
 *
 * JWT認証付き WebSocket
 */
export default class ChatClient {
    token;
    wsHost;
    ws;
    addMessage;
    user;

    constructor(token, wsHost) {
        this.token = token;
        this.wsHost = wsHost;

        this.ws = null;

        this.user = getAuthUser();

        this.initWebSocket();
    }

    /** WebSocket 接続初期化 */
    initWebSocket() {
        console.log(`[DEBUG] Connecting WebSocket with token: ${this.token}`);

        this.ws = new WebSocket(`ws://${this.wsHost}?token=${this.token}`);

        this.ws.onopen = () => {
            console.log("[DEBUG] WebSocket connected");
        };

        this.ws.onmessage = (event) => this.handleMessage(event);

        this.ws.onclose = (event) => {
            console.log("[DEBUG] WebSocket closed", event);
        };

        this.ws.onerror = (err) => {
            console.error("[DEBUG] WebSocket error", err);
        };
    }

    /** メッセージ送信 */
    sendMessage(message, type) {
        console.log("sendMessage type", type);

        if (!message || !this.ws || this.ws.readyState !== WebSocket.OPEN) {
            console.warn("[DEBUG] WebSocket not ready or empty message");
            return;
        }

        if (type === "websocket") {
            // WebSocketに直接送信する時

            const payload = { data: { message, name: this.user.name } };
            console.log("[DEBUG] Sending message", payload);

            this.ws.send(JSON.stringify(payload));
        } else if (type === "redis") {
            // サーバーを通して、redisを経由する時

            sendMessage(message);
        }
    }

    /** メッセージ受信 */
    handleMessage(event) {
        let data;
        try {
            data = JSON.parse(event.data);
        } catch (err) {
            console.error("[DEBUG] Failed to parse message", event.data, err);
            return;
        }

        console.log("[DEBUG] Received message", data);

        if (data.type == "message") this.addMessage(data);
    }
}
