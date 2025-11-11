const WebSocket = require('ws');
const jwt = require('jsonwebtoken');

/**
 * WebSocketServerApp
 * 認証付き WebSocket サーバー。純粋なロジックはこのクラスに閉じ込める。
 */
class WebSocketServerApp {
  constructor(options = {}) {
    const { host = '0.0.0.0', port = 8080 } = options;

    this.wss = new WebSocket.Server({ host, port });

    // 新しいクライアント接続
    this.wss.on('connection', (ws, req) => this.handleConnection(ws, req));

    console.log(`WebSocket server running on ws://${host}:${port}`);
  }

  /**
   * 接続時の認証 + イベント設定
   */
  handleConnection(ws, req) {
    const user = this.authenticate(req);

    if (!user) {
      console.log('invalid authenticate');
      ws.close();
      return;
    }

    ws.user = user;
    console.log(`Authenticated: ${user.name}`);

    // メッセージ受信
    ws.on('message', (msg) => this.handleMessage(ws, msg));

    // 切断
    ws.on('close', () => {
      console.log(`Disconnected: ${ws.user?.name}`);
    });
  }

  /**
   * JWT 認証
   */
  authenticate(req) {
    const params = new URLSearchParams(req.url.replace('/?', ''));
    const token = params.get('token');

    console.log(`token: ${token}`);

    if (!token) return null;
    console.log(`WS_JWT_SECRET: ${process.env.WS_JWT_SECRET}`);

    try {
      const payload = jwt.verify(token, process.env.WS_JWT_SECRET);

      return {
        id: payload.sub,
        name: payload.name,
        token,
      };
    } catch {
      return null;
    }
  }

  /**
   * メッセージ受信処理
   */
  async handleMessage(ws, msg) {
    let incoming;

    try {
      incoming = JSON.parse(msg);
    } catch {
      return;
    }

    await this.callbackTest(ws, incoming);

    const data = {
      user: ws.user.name,
      user_id: ws.user.id,
      message: incoming.message,
    };

    this.broadcast(data);
  }

  async callbackTest(ws, incoming) {
    // Laravel API にも通知（JWT付き）
    try {
      const url = `${process.env.LARAVEL_API_URL}/api/chat/callback_test`;

      console.log(`send: ${url} token ${ws.user.token}`);
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${ws.user.token || ''}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ content: incoming.message }),
      });

      if (!response.ok) {
        console.error('APIエラー:', response.status, response.statusText);
        return;
      }

      // Laravel からの JSON を取得
      const data = await response.json();
      console.log('Laravelからの返却:', data);
    } catch (err) {
      console.error('Laravel API error:', err);
    }
  }

  /**
   * 全クライアントへ送信
   */
  broadcast(data) {
    const str = JSON.stringify(data);

    this.wss.clients.forEach((client) => {
      if (client.readyState === WebSocket.OPEN) {
        client.send(str);
      }
    });
  }
}

module.exports = WebSocketServerApp;
