import {escapeHtml} from '@/services/data/html'

// WebSocket クライアント側処理

// Blade から埋め込まれた JWT を使う
const token = window.WS_TOKEN;

// 接続開始
const ws = new WebSocket(`ws://127.0.0.1:8080?token=${token}`);

// HTMLエレメント
const messageInput = document.getElementById("message");
const sendBtn = document.getElementById("send-btn");
const chatBox = document.getElementById("chat-box");

// メッセージを受信したときの処理
ws.onmessage = (event) => {
    const data = JSON.parse(event.data);

    // 文字追加
    chatBox.innerHTML += `<p><strong>${escapeHtml(data.user)}:</strong> ${escapeHtml(data.message)}</p>`;
};

/** メッセージを送信 */
function sendMessage() {
    const message = messageInput.value.trim();
    if (!message) return;

    ws.send(JSON.stringify({ message }));
    messageInput.value = "";
}

// ボタンにイベント付与
sendBtn.addEventListener("click", sendMessage);

// Enterキー対応（任意）
messageInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") sendMessage();
});
