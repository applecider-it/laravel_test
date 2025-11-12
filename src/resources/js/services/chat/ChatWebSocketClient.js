import { escapeHtml } from '@/services/data/html';

/**
 * ChatWebSocketClient
 * JWT認証付き WebSocket クライアント
 */
export default class ChatWebSocketClient {
    /**
     * @param {string} token - Blade から埋め込まれた JWT
     * @param {string} chatBoxId - チャット表示エレメントID
     * @param {string} inputId - 入力エレメントID
     * @param {string} sendBtnId - 送信ボタンID
     */
    constructor(token, chatBoxId, inputId, sendBtnId) {
        this.token = token;
        this.chatBox = document.getElementById(chatBoxId);
        this.messageInput = document.getElementById(inputId);
        this.sendBtn = document.getElementById(sendBtnId);

        this.ws = null;

        this.initWebSocket();
        this.bindEvents();
    }

    /** WebSocket 接続初期化 */
    initWebSocket() {
        console.log(`[DEBUG] Connecting WebSocket with token: ${this.token}`);

        this.ws = new WebSocket(`ws://127.0.0.1:8080?token=${this.token}`);

        this.ws.onopen = () => {
            console.log('[DEBUG] WebSocket connected');
        };

        this.ws.onmessage = (event) => this.handleMessage(event);

        this.ws.onclose = (event) => {
            console.log('[DEBUG] WebSocket closed', event);
        };

        this.ws.onerror = (err) => {
            console.error('[DEBUG] WebSocket error', err);
        };
    }

    /** イベントのバインド */
    bindEvents() {
        this.sendBtn.addEventListener('click', () => this.sendMessage());
        this.messageInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') this.sendMessage();
        });
    }

    /** メッセージ送信 */
    sendMessage() {
        const message = this.messageInput.value.trim();
        if (!message || !this.ws || this.ws.readyState !== WebSocket.OPEN) {
            console.warn('[DEBUG] WebSocket not ready or empty message');
            return;
        }

        const payload = { message };
        console.log('[DEBUG] Sending message', payload);
        this.ws.send(JSON.stringify(payload));
        this.messageInput.value = '';
    }

    /** メッセージ受信 */
    handleMessage(event) {
        let data;
        try {
            data = JSON.parse(event.data);
        } catch (err) {
            console.error('[DEBUG] Failed to parse message', event.data, err);
            return;
        }

        console.log('[DEBUG] Received message', data);

        if (data.type == "newChat") this.recieveNewChat(data);
    }

    /** 新しいチャット受信時 */
    recieveNewChat(data) {
        if (this.chatBox) {
            this.chatBox.innerHTML += `<p><strong>${escapeHtml(data.user)}:</strong> ${escapeHtml(data.message)}</p>`;
            this.chatBox.scrollTop = this.chatBox.scrollHeight;
        }
    }
}
