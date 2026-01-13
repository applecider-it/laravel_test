import { WebSocket } from 'ws';

import { log } from '@/services/system/log.js';

import { WebSocketUser, Incoming } from '../types.js';

/**
 * WebSocket サーバー管理の全てのWebSocketサーバーのユーザー管理
 * 
 * 保存フォーマット
 * {id: { name,channel }}
 * 
 * 返却フォーマット
 * [ {id, name} ]
 */
export default class GlobalUsersCtrl {
  /** 全てのWebSocketサーバーのユーザー情報 */
  globalUsers = new Map();

  /** セット */
  setGlobalUser(sender: WebSocketUser, incoming: Incoming) {
    this.globalUsers.set(incoming.data.user.id, {
      name: incoming.data.user.name,
      channel: sender.channel,
    });
    log('GlobalUsersCtrl: setGlobalUser', incoming, sender, this.globalUsers);
  }

  /** 削除 */
  deleteGlobalUser(incoming: Incoming) {
    this.globalUsers.delete(incoming.data.user.id);
    log('GlobalUsersCtrl: deleteGlobalUser', incoming, this.globalUsers);
  }

  /** 全てのWebSocketサーバーのユーザー情報を返す */
  getGlobalUsers(ws: WebSocket) {
    const user = ws.user as WebSocketUser;
    const list = [...this.globalUsers.entries()]
      .filter(([_, row]) => row.channel === user.channel)
      .map(([id, row]) => ({
        id,
        name: row.name,
      }));
    log('GlobalUsersCtrl: getGlobalUsers', list);
    return list;
  }
}
