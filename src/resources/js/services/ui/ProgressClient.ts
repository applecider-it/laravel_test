/**
 * 経過クライアント
 */
export default class ProgressClient {
    token;
    wsHost;
    ws;
    callback;

    constructor(token, wsHost) {
        this.token = token;
        this.wsHost = wsHost;

        this.ws = null;

        this.initWebSocket();
    }

    /** WebSocket 接続初期化 */
    private initWebSocket() {
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

    /** メッセージ受信 */
    private handleMessage(event) {
        let data;
        try {
            data = JSON.parse(event.data);
        } catch (err) {
            console.error("[DEBUG] Failed to parse message", event.data, err);
            return;
        }

        console.log("[DEBUG] Received message", data);

        this.callback(data);
    }
}
