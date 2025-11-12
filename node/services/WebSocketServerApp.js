import WebSocket, { WebSocketServer } from 'ws';

import Auth from './web-socket-server-app/Auth.js';

import ChatCannnel from './channels/ChatCannnel.js';

import { log } from './log.js';

/**
 * WebSocket サーバー管理
 */
export default class WebSocketServerApp {
  constructor(options = {}) {
    this.auth = new Auth();

    this.channels = {};
    this.channels.chat = new ChatCannnel();

    const { host = '0.0.0.0', port = 8080 } = options;

    this.wss = new WebSocketServer({ host, port });

    this.wss.on('connection', (ws, req) => this.handleConnection(ws, req));

    log(`WebSocket server running on ws://${host}:${port}`);
  }

  /** コネクション時 */
  handleConnection(ws, req) {
    const user = this.auth.authenticate(req);

    if (!user) {
      log('invalid authenticate');
      ws.close();
      return;
    }

    ws.user = user;
    log(`Authenticated: ${user.name}`);

    ws.on('message', (msg) => this.handleMessage(ws, msg));

    ws.on('close', () => {
      log(`Disconnected: ${ws.user?.name}`);
    });
  }

  /** メッセージ取得時 */
  async handleMessage(ws, msg) {
    let incoming;

    try {
      incoming = JSON.parse(msg);
    } catch {
      return;
    }

    log('incoming', incoming);

    // これがないとLaravelでrecieveしたときに止まる
    ws.send(JSON.stringify({ type: 'sended', ok: true }));

    if (incoming.channel == 'chat') {
      this.channels.chat.handleMessage(this.wss, ws, incoming);
    }
  }
}
