import { WebSocket, WebSocketServer, type RawData } from 'ws';
import { IncomingMessage } from 'http';

import { log } from '@/services/system/log.js';

import Auth from './Auth.js';

import { WebSocketUser, Incoming } from '../types.js';

/**
 * WebSocket サーバーのWebSocket管理
 */
export default class WebSocketCtrl {
  /** 権限管理サブクラス */
  auth;
  /** WebSockerサーバーインスタンス */
  wss: WebSocketServer;
  /** メッセージ受信時のコールバック */
  callback: Function;

  constructor(host: string, port: number, auth: Auth, callback: Function) {
    this.auth = auth;
    this.callback = callback;

    this.wss = new WebSocketServer({ host, port });

    this.wss.on('connection', (ws, req) => this.handleConnection(ws, req));

    log(`WebSocket server running on ws://${host}:${port}`);
  }

  /** コネクション時 */
  handleConnection(ws: WebSocket, req: IncomingMessage) {
    const user = this.auth.authenticate(req);

    if (!user) {
      log('invalid authenticate');
      ws.close();
      return;
    }

    ws.user = user;
    log(`Authenticated:`, user.name);

    ws.on('message', (msg) => this.handleMessage(ws, msg));

    ws.on('close', () => {
      log(`Disconnected: ${ws.user?.name}`);
    });
  }

  /** メッセージ取得時 */
  async handleMessage(senderWs: WebSocket, msg: RawData) {
    let incoming: Incoming;
    const sender = senderWs.user as WebSocketUser;

    try {
      incoming = JSON.parse(String(msg));
    } catch {
      return;
    }

    // これがないとLaravelでrecieveしたときに止まる
    // Laravelでrecieveしない場合はいらない
    senderWs.send(JSON.stringify({ type: 'sended', ok: true }));

    await this.callback(sender, incoming);
  }
}
