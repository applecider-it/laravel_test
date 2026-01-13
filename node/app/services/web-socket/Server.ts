import { WebSocket, WebSocketServer } from 'ws';

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
import GlobalUsersCtrl from './server/GlobalUsersCtrl.js';

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
  /** WebSocket サーバーの全てのWebSocketサーバーのユーザー管理 */
  globalUsersCtrl;

  /** システムから送信するときの送信タイプ */
  //systemSendType = 'websocket';
  systemSendType = 'redis';

  constructor() {
    const host = appConfig.webSocket.host;
    const port = appConfig.webSocket.port;
    const redisUrl = appConfig.redis.url;

    this.auth = new Auth();

    this.redisCtrl = new RedisCtrl(
      async (sender: WebSocketUser, incoming: Incoming, type: string) => {
        await this.onRedisMessage(sender, incoming, type);
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
    this.globalUsersCtrl = new GlobalUsersCtrl();
  }

  /** Redisメッセージ受信時の処理 */
  async onRedisMessage(
    sender: WebSocketUser,
    incoming: Incoming,
    type: string
  ) {
    this.updateGlobalUsers(sender, incoming, type);

    await this.sendCommon(sender, incoming, type);
  }

  /** 接続時の処理 */
  async onConnect(wss: WebSocketServer, ws: WebSocket) {
    // 接続したユーザーのみ送信
    ws.send(
      JSON.stringify({
        type: 'connected',
        users: this.getGlobalUsers(wss, ws),
      })
    );

    // 同じチャンネルへの全体送信

    const user = ws.user as WebSocketUser;

    const channel = user.channel;
    const type = 'connectOther';
    const data = {
      user: toBroadcastUser(user),
    };

    await this.sendBySystem(channel, data, type);
  }

  /** 切断時の処理 */
  async onDisconnect(wss: WebSocketServer, ws: WebSocket) {
    // 同じチャンネルへの全体送信

    const user = ws.user as WebSocketUser;

    const channel = user.channel;
    const type = 'disconnectOther';
    const data = {
      user: toBroadcastUser(user),
    };

    await this.sendBySystem(channel, data, type);
  }

  /** システムからの全体送信 */
  async sendBySystem(channel: string, data: any, type: string) {
    if (this.systemSendType === 'redis') {
      await this.redisCtrl.publish(channel, data, type);
    } else {
      const incoming: Incoming = {
        data: data,
      };

      await this.sendCommon(getSystemUser(channel), incoming, type);
    }
  }

  /** WebSocket, Redis共通の送信処理 */
  async sendCommon(sender: WebSocketUser, incoming: Incoming, type: string) {
    log('incoming', incoming);
    log('sender', sender);

    let data = incoming.data;

    if (type === 'message') {
      data = await this.cannelsCtrl
        .getChannel(sender.channel)
        .callbackCreateData(sender, incoming);
    }

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
      this.cannelsCtrl,
      type
    );
  }

  /** 全てのWebSocketサーバーのユーザー情報を更新 */
  updateGlobalUsers(sender: WebSocketUser, incoming: Incoming, type: string) {
    if (this.systemSendType === 'redis') {
      if (type === 'connectOther') {
        log('connectOther', incoming, sender);
        this.globalUsersCtrl.setGlobalUser(sender, incoming);
        log('connectOther globalUsers', this.globalUsersCtrl.globalUsers);
      } else if (type === 'disconnectOther') {
        this.globalUsersCtrl.deleteGlobalUser(incoming);
        log('disconnectOther globalUsers', this.globalUsersCtrl.globalUsers);
      }
    }
  }

  /** 全てのWebSocketサーバーのユーザー情報を返す */
  getGlobalUsers(wss: WebSocketServer, ws: WebSocket) {
    if (this.systemSendType === 'redis') {
      return this.globalUsersCtrl.getGlobalUsers(ws);
    } else {
      return getSameChannelUsers(wss, ws);
    }
  }
}
