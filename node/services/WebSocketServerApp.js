import WebSocket, { WebSocketServer } from 'ws';
import jwt from 'jsonwebtoken';

import Test from './web-socket-server-app/Test.js';

/**
 * WebSocketServerApp
 * 認証付き WebSocket サーバー。純粋なロジックはこのクラスに閉じ込める。
 */
export default class WebSocketServerApp {
  constructor(options = {}) {
    this.test = new Test();

    const { host = '0.0.0.0', port = 8080 } = options;

    this.wss = new WebSocketServer({ host, port });

    this.wss.on('connection', (ws, req) => this.handleConnection(ws, req));

    console.log(`WebSocket server running on ws://${host}:${port}`);
  }

  handleConnection(ws, req) {
    const user = this.authenticate(req);

    if (!user) {
      console.log('invalid authenticate');
      ws.close();
      return;
    }

    ws.user = user;
    console.log(`Authenticated: ${user.name}`);

    ws.on('message', (msg) => this.handleMessage(ws, msg));

    ws.on('close', () => {
      console.log(`Disconnected: ${ws.user?.name}`);
    });
  }

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

  async handleMessage(ws, msg) {
    let incoming;

    try {
      incoming = JSON.parse(msg);
    } catch {
      return;
    }

    await this.test.callbackTest(ws, incoming);

    ws.send(JSON.stringify({ type: "sended", ok: true }));

    const data = {
      type: "newChat",
      user: ws.user.name,
      user_id: ws.user.id,
      message: incoming.message,
    };

    this.broadcast(data);
  }

  broadcast(data) {
    const str = JSON.stringify(data);

    this.wss.clients.forEach((client) => {
      if (client.readyState === WebSocket.OPEN) {
        console.log(`broadcast: ${client.user?.name}`)
        if (client.user.id !== 'system') {
          console.log(`send: ${client.user?.name}`)
          client.send(str);
        }
      }
    });
  }
}
