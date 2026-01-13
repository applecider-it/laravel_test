import { WebSocket, WebSocketServer, type RawData } from 'ws';
import { IncomingMessage } from 'http';

import { log } from '@/services/system/log.js';

import {
  broadcastSameChannel,
  getSameChannelUsers,
} from './utils/broadcast.js';

import Auth from './server/Auth.js';
import RedisCtrl from './server/RedisCtrl.js';
import WebSocketCtrl from './server/WebSocketCtrl.js';
import ChannelsCtrl from './server/ChannelsCtrl.js';

import { WebSocketUser, Incoming, BroadcastSendData } from './types.js';

import { appConfig } from '@/config/config.js';

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
  /** WebSocket サーバーのChannel管理 */
  cannelsCtrl;

  constructor() {
    const host = appConfig.webSocket.host;
    const port = appConfig.webSocket.port;
    const redisUrl = appConfig.redis.url;

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
      },
      (wss: WebSocketServer, ws: WebSocket) => {
        ws.send(
          JSON.stringify({
            type: 'connected',
            users: getSameChannelUsers(wss, ws),
          })
        );
      },
      (wss: WebSocketServer, ws: WebSocket) => {
        const sender = ws.user as WebSocketUser;
        const sendData: BroadcastSendData = {
          type: 'disconnect',
          sender: {
            name: sender.name,
            id: sender.id,
          },
          data: null,
        };

        broadcastSameChannel(
          sendData,
          sender,
          null,
          this.webSocketCtrl.wss,
          this.cannelsCtrl
        );
      }
    );

    this.cannelsCtrl = new ChannelsCtrl();
  }

  /** WebSocket, Redis共通の送信処理 */
  async sendCommon(sender: WebSocketUser, incoming: Incoming) {
    log('incoming', incoming);
    log('sender', sender);

    const data = await this.cannelsCtrl
      .getChannel(sender.channel)
      .callbackCreateData(sender, incoming);

    const sendData: BroadcastSendData = {
      type: 'message',
      sender: {
        name: sender.name,
        id: sender.id,
      },
      data: data,
    };

    broadcastSameChannel(
      sendData,
      sender,
      incoming,
      this.webSocketCtrl.wss,
      this.cannelsCtrl
    );
  }
}
