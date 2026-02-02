import { getAuthUser } from "@/services/app/application";
import { MyEcho } from "@/services/app/echo";
import { showToast } from "@/services/ui/message";

import { sendMessageEcho } from "@/services/api/rpc/chat-rpc";

/**
 * チャット(Echo)クライアント
 */
export default class ChatEchoClient {
    addMessage;
    setUsers;
    user;
    room;
    users = [];

    constructor(room) {
        this.room = room;

        this.user = getAuthUser();

        this.initEcho();
    }

    /** Laravel Echo 接続初期化 */
    initEcho() {
        MyEcho.join(`Chat.${this.room}`)
            .here((users) => this.setupUsers(users))
            .joining((user) => this.addUser(user))
            .leaving((user) => this.removeUser(user))
            .listen("ChatMessageSent", (e) => this.handleMessageEcho(e));
    }

    /** メッセージ送信 */
    sendMessage(message: string, type: string, options: any) {
        console.log("sendMessage type", type);

        if (!message) {
            console.warn("[DEBUG] WebSocket not ready or empty message");
            return;
        }

        sendMessageEcho(message, this.room, options);
    }

    /** ユーザー一覧セットアップ */
    setupUsers(users) {
        console.log("users", users);
        this.users = users;
        this.refreshUsers();
    }

    /** ユーザー追加（重複防止付き） */
    addUser(user) {
        const exists = this.users.some((u) => u.id === user.id);

        if (!exists) {
            console.log("push user", user);
            this.users.push(user);

            showToast(`${user.name}さんが、入室しました。`);

            this.refreshUsers();
        }
    }

    /** ユーザー削除 */
    removeUser(user) {
        this.users = this.users.filter((u) => u.id !== user.id);

        showToast(`${user.name}さんが、退室しました。`);

        this.refreshUsers();
    }

    /** ユーザー一覧を反映 */
    refreshUsers() {
        this.setUsers(this.users);
    }

    /** Echo メッセージ受信 */
    handleMessageEcho(e) {
        console.log("handleMessageEcho", e);

        this.addMessage({
            data: {
                message: e.message,
                name: e.user.name,
            },
        });
    }
}
