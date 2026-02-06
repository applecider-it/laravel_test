import { WebSocket, WebSocketServer, type RawData } from 'ws';
import { IncomingMessage } from 'http';

import { log } from '@/services/system/log.js';

import { authenticate } from './utils/authUtil.js';

import { WebSocketUser, Incoming } from '../types.js';

/**
 * WebSocket サーバーのWebSocket管理
 */
export default class WebSocketCtrl {
  /** WebSockerサーバーインスタンス */
  wss: WebSocketServer;
  /** メッセージ受信時のコールバック */
  private callback: Function;
  /** 接続時のコールバック */
  private callbackConnected: Function;
  /** 切断時のコールバック */
  private callbackDisconnected: Function;

  constructor(
    host: string,
    port: number,
    callback: Function,
    callbackConnected: Function,
    callbackDisconnected: Function
  ) {
    this.callback = callback;
    this.callbackConnected = callbackConnected;
    this.callbackDisconnected = callbackDisconnected;

    this.wss = new WebSocketServer({ host, port });

    this.wss.on('connection', (ws, req) => this.handleConnection(ws, req));

    log(`WebSocket server running on ws://${host}:${port}`);
  }

  /** コネクション時 */
  private handleConnection(ws: WebSocket, req: IncomingMessage) {
    const user = authenticate(req);

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
      this.callbackDisconnected(this.wss, ws);
    });

    this.callbackConnected(this.wss, ws);
  }

  /** メッセージ取得時 */
  private async handleMessage(senderWs: WebSocket, msg: RawData) {
    let incoming: Incoming;
    const sender = senderWs.user as WebSocketUser;

    try {
      incoming = JSON.parse(String(msg));
    } catch {
      return;
    }

    await this.callback(sender, incoming);
  }
}
