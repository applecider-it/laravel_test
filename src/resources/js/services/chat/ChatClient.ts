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

    constructor(token, wsHost) {
        this.token = token;
        this.wsHost = wsHost;

        this.ws = null;

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
    sendMessage(message) {
        if (!message || !this.ws || this.ws.readyState !== WebSocket.OPEN) {
            console.warn("[DEBUG] WebSocket not ready or empty message");
            return;
        }

        const payload = { data: { message } };
        console.log("[DEBUG] Sending message", payload);
        this.ws.send(JSON.stringify(payload));
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
