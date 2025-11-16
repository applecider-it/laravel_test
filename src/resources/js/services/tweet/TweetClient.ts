import axios from 'axios';

/**
 * ツイートクライアント
 * 
 * JWT認証付き WebSocket
 */
export default class TweetClient {
    token;
    wsHost;
    ws;
    channel: string;
    setTweetContainers;

    constructor(token, wsHost) {
        this.token = token;
        this.wsHost = wsHost;

        this.ws = null;

        this.channel = "tweet";

        this.setTweetContainers = null;

        this.initWebSocket();
    }

    /** WebSocket 接続初期化 */
    initWebSocket() {
        console.log(`[DEBUG] Connecting WebSocket with token: ${this.token}`);

        this.ws = new WebSocket(
            `ws://${this.wsHost}?token=${this.token}&channel=${this.channel}`
        );

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

        if (data.type == "newTweet") this.recieveNewTweet(data);
    }

    /** 新しいツイート受信時 */
    recieveNewTweet(data) {
        console.log('recieveNewTweet', data);

        const tweet = data.data.tweet;
        console.log('recieveNewTweet tweet', tweet);
        this.setTweetContainers((list) => [{tweet, isNew: true}, ...list]);
    }

    /** 新しいツイート送信 */
    async sendTweet(content) {
        const response = await axios.post('/tweets/api', { content });
        console.log('response.data', response.data);
        return response.data.data;
    }
}
