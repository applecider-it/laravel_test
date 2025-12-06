import { WebSocket, WebSocketServer, type RawData } from 'ws';
import { IncomingMessage } from 'http';

import { log } from '@/services/system/log.ts';

import ChatCannnel from '@/services/channels/ChatCannnel.ts';
import TweetCannnel from '@/services/channels/TweetCannnel.ts';
import { canBroadcast } from '@/services/web-socket/broadcast.ts';

import Auth from './server/Auth.ts';
import RedisCtrl from './server/RedisCtrl.ts';
import WebSocketCtrl from './server/WebSocketCtrl.ts';

import { WebSocketUser, Incoming, BroadcastSendData } from './types';

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
  }

  /** WebSocket, Redis共通の送信処理 */
  async sendCommon(sender: WebSocketUser, incoming: Incoming) {
    log('incoming', incoming);
    log('sender', sender);

    this.handleMessage(sender, incoming);
  }

  /** チャンネルごとのインスタンス */
  getChannel(channel: string) {
    return this.channels[channel as 'chat' | 'tweet'];
  }

  /** メッセージ取得時 */
  async handleMessage(sender: WebSocketUser, incoming: Incoming) {
    const data = await this.getChannel(sender.channel).callbackCreateData(
      sender,
      incoming
    );

    const sendData: BroadcastSendData = {
      type: 'message',
      info: sender.info,
      id: sender.id,
      data: data,
    };

    this.broadcast(sendData, sender, incoming);
  }

  /** 全体送信 */
  private broadcast(
    sendData: BroadcastSendData,
    sender: WebSocketUser,
    incoming: Incoming
  ) {
    const wss = this.webSocketCtrl.wss;
    const sendDataStr = JSON.stringify(sendData);

    wss.clients.forEach(async (client: WebSocket) => {
      const user = client.user as WebSocketUser;
      log(`broadcast:`, user.info);

      if (!canBroadcast(client, sender.channel)) return;

      log(`canBroadcast:`, user.info);

      const sendable = await this.getChannel(sender.channel).callbackCheckSend(
        sender,
        user,
        incoming
      );

      if (!sendable) return;

      log(`sendable:`, user.info);

      client.send(sendDataStr);
    });
  }
}
