import { WebSocket, WebSocketServer, type RawData } from 'ws';
import { IncomingMessage } from 'http';

import { log } from '@/services/system/log.ts';

import ChatCannnel from '@/services/channels/ChatCannnel.ts';
import TweetCannnel from '@/services/channels/TweetCannnel.ts';

import Auth from './server/Auth.ts';
import RedisCtrl from './server/RedisCtrl.ts';
import WebSocketCtrl from './server/WebSocketCtrl.ts';

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
  /** WebSocket サーバーのRedis管理 */
  redisCtrl;
  /** WebSocket サーバーのRedis管理 */
  webSocketCtrl;
  /** 全てのチャンネルクラスを集めたハッシュ */
  channels: Channels;

  constructor({ host = '0.0.0.0', port = 8080 }: Options) {
    this.auth = new Auth();

    this.redisCtrl = new RedisCtrl(
      async (sender: WebSocketUser, incoming: Incoming) => {
        await this.sendCommon(sender, incoming);
      }
    );

    this.webSocketCtrl = new WebSocketCtrl(
      host,
      port,
      this.auth,
      async (sender: WebSocketUser, incoming: Incoming) => {
        await this.sendCommon(sender, incoming);
      }
    );

    this.channels = {
      chat: new ChatCannnel(),
      tweet: new TweetCannnel(),
    };

    log(`WebSocket server running on ws://${host}:${port}`);
  }

  /** WebSocket, Redis共通の送信処理 */
  async sendCommon(sender: WebSocketUser, incoming: Incoming) {
    log('incoming', incoming);
    log('sender', sender);

    const channel = sender.channel as 'chat' | 'tweet';

    const handler = this.channels[channel];
    if (handler) {
      handler.handleMessage(this.webSocketCtrl.wss, sender, incoming);
    }
  }
}
