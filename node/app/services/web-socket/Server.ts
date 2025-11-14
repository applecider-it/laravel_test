import WebSocket, { WebSocketServer } from 'ws';

import { log } from '@/services/system/log.ts';

import ChatCannnel from '@/services/channels/ChatCannnel.ts';

import Auth from './server/Auth.ts';

type Options = {
  host: string;
  port: number;
}

/**
 * WebSocket サーバー管理
 */
export default class Server {
  /** 権限管理サブクラス */
  auth;
  /** 全てのチャンネルクラスを集めたハッシュ */
  channels: any;
  /** WebSockerサーバーインスタンス */
  wss;

  constructor({ host = '0.0.0.0', port = 8080 }: Options) {
    this.auth = new Auth();

    this.channels = {};
    this.channels.chat = new ChatCannnel();

    this.wss = new WebSocketServer({ host, port });

    this.wss.on('connection', (ws, req) => this.handleConnection(ws, req));

    log(`WebSocket server running on ws://${host}:${port}`);
  }

  /** コネクション時 */
  handleConnection(ws: any, req: any) {
    const user = this.auth.authenticate(req);

    if (!user) {
      log('invalid authenticate');
      ws.close();
      return;
    }

    ws.user = user;
    log(`Authenticated:`, user.info);

    ws.on('message', (msg: any) => this.handleMessage(ws, msg));

    ws.on('close', () => {
      log(`Disconnected: ${ws.user?.name}`);
    });
  }

  /** メッセージ取得時 */
  async handleMessage(ws: any, msg: any) {
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
