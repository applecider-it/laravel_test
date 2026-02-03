import { getAuthUser } from "@/services/app/application";
import { showToast } from "@/services/ui/message";

import { sendMessage } from "@/services/api/rpc/chat-rpc";

/**
 * チャットクライアント
 *
 * JWT認証付き WebSocket
 */
export default class ChatClient {
    private token;
    private wsHost;
    private ws;
    private user;
    private room;
    private users = [];

    addMessage;
    setUsers;

    constructor(token, wsHost, room) {
        this.token = token;
        this.wsHost = wsHost;
        this.room = room;

        this.ws = null;

        this.user = getAuthUser();

        this.initWebSocket();
    }

    /** WebSocket 接続初期化 */
    private initWebSocket() {
        console.log(`[DEBUG] Connecting WebSocket with token: ${this.token}`);

        this.ws = new WebSocket(`ws://${this.wsHost}?token=${this.token}`);

        this.ws.onopen = () => {
            console.log("[DEBUG] WebSocket connected");
        };

        this.ws.onmessage = (event) => this.onMessage(event);

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

    /** 全てのタイプのメッセージ受信 */
    private onMessage(event) {
        let data;
        try {
            data = JSON.parse(event.data);
        } catch (err) {
            console.error("[DEBUG] Failed to parse message", event.data, err);
            return;
        }

        console.log("[DEBUG] Received message", data);

        if (data.type == "message") {
            // メッセージ受信時

            this.handleMessage(data);
        } else if (data.type == "connected") {
            // 自分が接続したとき

            this.setupUsers(data.users);
        } else if (data.type == "connectOther") {
            // 自分を含めて誰かが接続したとき

            this.addUser(data.data.user);
        } else if (data.type == "disconnectOther") {
            // 自分を含めて誰かが切断したとき（自分のときは、ページ遷移している）

            this.removeUser(data.data.user);
        }
    }

    /** ユーザー一覧セットアップ */
    private setupUsers(users) {
        this.users = users;
        this.refreshUsers();
    }

    /** ユーザー追加（重複防止付き） */
    private addUser(user) {
        const exists = this.users.some((u) => u.id === user.id);

        if (!exists) {
            console.log("push user", user);
            this.users.push(user);

            if (this.user.id !== user.id) {
                showToast(`${user.name}さんが、入室しました。`);
            }

            this.refreshUsers();
        }
    }

    /** ユーザー削除 */
    private removeUser(user) {
        this.users = this.users.filter((u) => u.id !== user.id);

        showToast(`${user.name}さんが、退室しました。`);

        this.refreshUsers();
    }

    /** ユーザー一覧を反映 */
    private refreshUsers() {
        this.setUsers(this.users);
    }

    /** メッセージ受信 */
    private handleMessage(data) {
        console.log("handleMessage", data);

        this.addMessage(data);
    }
}
