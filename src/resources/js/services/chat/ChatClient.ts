import { getAuthUser } from "@/services/app/application";
import { showToast } from "@/services/ui/message";

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
    setUsers;
    user;
    room;
    users = [];

    constructor(token, wsHost, room) {
        this.token = token;
        this.wsHost = wsHost;
        this.room = room;

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
    sendMessage(message: string, type: string, options: any) {
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

            sendMessage(message, this.room);
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

        let updateUsers = false;

        if (data.type == "message") {
            // メッセージ受信時

            this.addMessage(data);
        } else if (data.type == "connected") {
            // 自分が接続したとき

            console.log("connected", data.users);
            data.users.forEach((user) => this.addUser(user));
            updateUsers = true;
        } else if (data.type == "connectOther") {
            // 自分を含めて他人が接続したとき

            console.log("connectOther", data.data.user);
            this.addUser(data.data.user);
            updateUsers = true;

            showToast(`${data.data.user.name}さんが、入室しました。`);
        } else if (data.type == "disconnectOther") {
            // 自分を含めて他人が切断したとき（自分のときは、ページ遷移している）

            console.log("disconnectOther", data.data.user);
            this.removeUser(data.data.user);
            updateUsers = true;

            showToast(`${data.data.user.name}さんが、退室しました。`);
        }

        // 一覧の変更があるときは、ユーザー一覧を反映する
        if (updateUsers) {
            this.setUsers(this.users);
        }
    }

    /** ユーザー追加（重複防止付き） */
    addUser(user) {
        const exists = this.users.some((u) => u.id === user.id);

        if (!exists) {
            console.log("push user", user);
            this.users.push(user);
        }
    }

    /** ユーザー削除 */
    removeUser(user) {
        this.users = this.users.filter((u) => u.id !== user.id);
    }
}
