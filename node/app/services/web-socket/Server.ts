import { WebSocket, WebSocketServer, type RawData } from 'ws';
import { IncomingMessage } from 'http';

import { log } from '@/services/system/log.js';

import ChatCannnel from '@/services/channels/ChatCannnel.js';
import BaseCannnel from '@/services/channels/BaseCannnel.js';

import { canBroadcast } from '@/services/web-socket/broadcast.js';

import Auth from './server/Auth.js';
import RedisCtrl from './server/RedisCtrl.js';
import WebSocketCtrl from './server/WebSocketCtrl.js';

import { WebSocketUser, Incoming, BroadcastSendData } from './types.js';

type Channels = {
  chat: ChatCannnel;
  base: BaseCannnel;
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

  constructor() {
    const host: string = process.env.APP_WS_HOST!;
    const port: number = Number(process.env.APP_WS_PORT!);
    const redisUrl: string = process.env.APP_REDIS_URL!;

    this.auth = new Auth();

    this.redisCtrl = new RedisCtrl(
      async (sender: WebSocketUser, incoming: Incoming) => {
        await this.sendCommon(sender, incoming);
      },
      redisUrl
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
      base: new BaseCannnel(),
    };
  }

  /** WebSocket, Redis共通の送信処理 */
  async sendCommon(sender: WebSocketUser, incoming: Incoming) {
    log('incoming', incoming);
    log('sender', sender);

    const data = await this.getChannel(sender.channel).callbackCreateData(
      sender,
      incoming
    );

    const sendData: BroadcastSendData = {
      type: 'message',
      sender: {
        name: sender.name,
        id: sender.id,
      },
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
      log(`broadcast:`, user.name);

      if (!canBroadcast(client, sender.channel)) return;

      log(`canBroadcast:`, user.name);

      const sendable = await this.getChannel(sender.channel).callbackCheckSend(
        sender,
        user,
        incoming
      );

      if (!sendable) return;

      log(`sendable:`, user.name);

      client.send(sendDataStr);
    });
  }

  /** チャンネルごとのインスタンス */
  getChannel(channelStr: string) {
    const [channel, paramsStr] = channelStr.split(':');

    if (channel in this.channels) {
      return this.channels[channel as keyof Channels];
    }

    return this.channels.base;
  }
}
