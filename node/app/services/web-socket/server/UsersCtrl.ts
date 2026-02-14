import { type WebSocket, type WebSocketServer } from 'ws';

import { log } from '@/services/system/log.js';

import { WebSocketUser, Incoming } from '../types.js';

import BroadcastCtrl from './BroadcastCtrl.js';

/**
 * WebSocket サーバー管理の全てのユーザー管理
 * 
 * systemSendTypeがredisの時は、globalUsersの値に、複数サーバーのユーザー情報を蓄積させる。
 *
 * globalUsers変数詳細
 * 
 * 保存フォーマット
 * {id: { name,channel }}
 *
 * 返却フォーマット
 * [ {id, name} ]
 */
export default class UsersCtrl {
  /** 全てのWebSocketサーバーのユーザー情報 */
  private globalUsers = new Map();

  /** WebSocket サーバーのBroadcast管理 */
  private broadcastCtrl;

  /** システムから送信するときの送信タイプ */
  private systemSendType;

  constructor(systemSendType: string, broadcastCtrl: BroadcastCtrl) {
    this.systemSendType = systemSendType;
    this.broadcastCtrl = broadcastCtrl;
  }

  /** システムからの送信にRedisを使うときだけ、ユーザー情報を更新 */
  updateGlobalUser(sender: WebSocketUser, incoming: Incoming, type: string) {
    if (this.systemSendType === 'redis') {
      // システムからの送信にRedisを使うとき

      if (type === 'connectOther') {
        // ほかのユーザーが接続したとき

        this.setGlobalUser(sender, incoming);
      } else if (type === 'disconnectOther') {
        // ほかのユーザーが切断したとき

        this.deleteGlobalUser(incoming);
      }
    }
  }

  /** UserIDをキーにして、アップサート */
  private setGlobalUser(sender: WebSocketUser, incoming: Incoming) {
    this.globalUsers.set(incoming.data.user.id, {
      name: incoming.data.user.name,
      channel: sender.channel,
    });
    log('UsersCtrl: setGlobalUser', incoming, sender, this.globalUsers);
  }

  /** UserIDをキーにして、削除 */
  private deleteGlobalUser(incoming: Incoming) {
    this.globalUsers.delete(incoming.data.user.id);
    log('UsersCtrl: deleteGlobalUser', incoming, this.globalUsers);
  }

  /** 同じチャンネルのユーザー公開情報一覧 */
  getSameChannelUsers(wss: WebSocketServer, ws: WebSocket) {
    if (this.systemSendType === 'redis') {
      // システムからの送信にRedisを使うとき

      return this.getSameChannelGlobalUsers(ws);
    } else {
      // システムからの送信にWebSocketを使うとき

      return this.getSameChannelWebSocketUsers(wss, ws);
    }
  }

  /** 同じチャンネルのユーザー公開情報一覧 (WebSocket) */
  private getSameChannelWebSocketUsers(wss: WebSocketServer, ws: WebSocket) {
    const target = ws.user as WebSocketUser;
    const list: any[] = [];
    wss.clients.forEach(async (client: WebSocket) => {
      const user = client.user as WebSocketUser;

      if (!this.broadcastCtrl.canBroadcast(client, target.channel)) return;

      list.push({
        id: user.id,
        name: user.name,
      });
    });

    return list;
  }

  /** 同じチャンネルのユーザー公開情報一覧 (Redis経由) */
  private getSameChannelGlobalUsers(ws: WebSocket) {
    const user = ws.user as WebSocketUser;
    const list = [...this.globalUsers.entries()]
      .filter(([_, row]) => row.channel === user.channel)
      .map(([id, row]) => ({
        id,
        name: row.name,
      }));
    log('UsersCtrl: getGlobalUsers', list);
    return list;
  }
}
