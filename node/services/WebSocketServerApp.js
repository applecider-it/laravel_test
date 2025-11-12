import WebSocket, { WebSocketServer } from 'ws';

import Test from './web-socket-server-app/Test.js';
import Auth from './web-socket-server-app/Auth.js';

import ChatCannnel from './channels/ChatCannnel.js';

/**
 * WebSocketServerApp
 * 認証付き WebSocket サーバー。純粋なロジックはこのクラスに閉じ込める。
 */
export default class WebSocketServerApp {
  constructor(options = {}) {
    this.test = new Test();
    this.auth = new Auth();

    this.channels = {};
    this.channels.chat = new ChatCannnel();

    const { host = '0.0.0.0', port = 8080 } = options;

    this.wss = new WebSocketServer({ host, port });

    this.wss.on('connection', (ws, req) => this.handleConnection(ws, req));

    console.log(`WebSocket server running on ws://${host}:${port}`);
  }

  handleConnection(ws, req) {
    const user = this.auth.authenticate(req);

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


  async handleMessage(ws, msg) {
    let incoming;

    try {
      incoming = JSON.parse(msg);
    } catch {
      return;
    }

    console.log('incoming', incoming)

    await this.test.callbackTest(ws, incoming);

    // これがないとLaravelでrecieveしたときに止まる
    ws.send(JSON.stringify({ type: "sended", ok: true }));

    if (incoming.channel == 'chat') {
      this.channels.chat.newChat(this.wss, ws, incoming);
    }
  }

}
