import { WebSocket, WebSocketServer, type RawData } from 'ws';
import { IncomingMessage } from 'http';

import { log } from '@/services/system/log.ts';

import ChatCannnel from '@/services/channels/ChatCannnel.ts';
import TweetCannnel from '@/services/channels/TweetCannnel.ts';

import Auth from './server/Auth.ts';

import { WebSocketUser, Incoming } from '@/types/types';

type Options = {
  host: string;
  port: number;
};

type Channels = {
  chat: ChatCannnel;
  tweet: TweetCannnel;
};

/**
 * WebSocket サーバー管理
 */
export default class Server {
  /** 権限管理サブクラス */
  auth;
  /** 全てのチャンネルクラスを集めたハッシュ */
  channels: Channels;
  /** WebSockerサーバーインスタンス */
  wss: WebSocketServer;

  constructor({ host = '0.0.0.0', port = 8080 }: Options) {
    this.auth = new Auth();

    this.channels = {
      chat: new ChatCannnel(),
      tweet: new TweetCannnel(),
    };

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
    log(`Authenticated:`, user.info);

    ws.on('message', (msg) => this.handleMessage(ws, msg));

    ws.on('close', () => {
      log(`Disconnected: ${ws.user?.info.name}`);
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

    log('incoming', incoming);
    log('sender', senderWs.user);

    // これがないとLaravelでrecieveしたときに止まる
    // Laravelでrecieveしない場合はいらない
    senderWs.send(JSON.stringify({ type: 'sended', ok: true }));

    const channel = sender.channel as 'chat'|'tweet';

    const handler = this.channels[channel];
    if (handler) {
      handler.handleMessage(this.wss, senderWs, incoming);
    }
  }
}
