import axios from "axios";

import { showToast } from "@/services/ui/message";
import { storeTweet } from "@/services/api/rpc/tweet-rpc";

/**
 * ツイートクライアント
 *
 * JWT認証付き WebSocket
 */
export default class TweetClient {
    token;
    wsHost;
    user;
    ws;
    setTweetContainers;

    constructor(token, wsHost, user) {
        this.token = token;
        this.wsHost = wsHost;
        this.user = user;

        this.ws = null;

        this.setTweetContainers = null;

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

        if (data.type == "message") this.recieveNewTweet(data);
    }

    /** 新しいツイート受信時 */
    recieveNewTweet(data) {
        console.log("recieveNewTweet", data);

        const tweet = data.data.tweet;
        console.log("recieveNewTweet tweet", tweet);
        this.setTweetContainers((list) => [{ tweet, isNew: true }, ...list]);

        if (this.user.id !== tweet.user.id)
            showToast("新しいツイートがあります。");
    }

    /** 新しいツイート送信 */
    async sendTweet(content) {
        const data = await storeTweet(content);
        console.log("sendTweet response data", data);
    }
}
