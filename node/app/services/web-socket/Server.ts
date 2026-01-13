import { WebSocket, WebSocketServer, type RawData } from 'ws';
import { IncomingMessage } from 'http';

import { log } from '@/services/system/log.js';
import { appConfig } from '@/config/config.js';

import {
  broadcastSameChannel,
  getSameChannelUsers,
  toBroadcastUser,
} from './utils/broadcast.js';
import { getSystemUser } from './utils/system.js';

import Auth from './server/Auth.js';
import RedisCtrl from './server/RedisCtrl.js';
import WebSocketCtrl from './server/WebSocketCtrl.js';
import ChannelsCtrl from './server/ChannelsCtrl.js';

import { WebSocketUser, Incoming, BroadcastSendData } from './types.js';

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
      async (sender: WebSocketUser, incoming: Incoming, type: string) => {
        await this.sendCommon(sender, incoming, type);
      },
      redisUrl
    );

    this.webSocketCtrl = new WebSocketCtrl(
      host,
      port,
      this.auth,
      async (sender: WebSocketUser, incoming: Incoming) => {
        await this.sendCommon(sender, incoming, 'message');
      },
      (wss: WebSocketServer, ws: WebSocket) => {
        this.onConnect(wss, ws);
      },
      (wss: WebSocketServer, ws: WebSocket) => {
        this.onDisconnect(wss, ws);
      }
    );

    this.cannelsCtrl = new ChannelsCtrl();
  }

  /** 接続時の処理 */
  async onConnect(wss: WebSocketServer, ws: WebSocket) {
    // 接続したユーザーのみ送信
    // 本来なら、usersの情報は、redisで管理しないといけない。あくまで、試作的な簡易実装。
    ws.send(
      JSON.stringify({
        type: 'connected',
        users: getSameChannelUsers(wss, ws),
      })
    );

    // 同じチャンネルへの全体送信
    // 本来なら、redis経由で送信しないといけない。あくまで、試作的な簡易実装。

    const sender = ws.user as WebSocketUser;

    const sendData: BroadcastSendData = {
      type: 'connectOther',
      sender: getSystemUser(sender.channel),
      data: {
        user: toBroadcastUser(sender),
      },
    };

    broadcastSameChannel(sendData, sender, null, wss, this.cannelsCtrl);
  }

  /** 切断時の処理 */
  async onDisconnect(wss: WebSocketServer, ws: WebSocket) {
    // 同じチャンネルへの全体送信
    // 本来なら、redis経由で送信しないといけない。あくまで、試作的な簡易実装。

    const sender = ws.user as WebSocketUser;

    const sendData: BroadcastSendData = {
      type: 'disconnectOther',
      sender: getSystemUser(sender.channel),
      data: {
        user: toBroadcastUser(sender),
      },
    };

    broadcastSameChannel(sendData, sender, null, wss, this.cannelsCtrl);
  }

  /** WebSocket, Redis共通の送信処理 */
  async sendCommon(sender: WebSocketUser, incoming: Incoming, type: string) {
    log('incoming', incoming);
    log('sender', sender);

    const data = await this.cannelsCtrl
      .getChannel(sender.channel)
      .callbackCreateData(sender, incoming);

    const sendData: BroadcastSendData = {
      type: type,
      sender: toBroadcastUser(sender),
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
