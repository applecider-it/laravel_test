import { log } from '@/services/system/log.js';

import { WebSocket, type WebSocketServer } from 'ws';

import { WebSocketUser, Incoming, BroadcastSendData } from '../types.js';

import type ChannelsCtrl from './ChannelsCtrl.js';

/**
 * WebSocket サーバーのBroadcast管理
 */
export default class BroadcastCtrl {
  /** 特定のチャンネルに、全体送信できるクライアントか確認 */
  public canBroadcast(client: WebSocket, channel: string) {
    const user = client.user as WebSocketUser;

    if (client.readyState === WebSocket.OPEN) {
      if (user.channel == channel) {
        return true;
      }
    }

    return false;
  }

  /** 同じチャンネルに全体送信 */
  broadcastSameChannel(
    sendData: BroadcastSendData,
    sender: WebSocketUser,
    incoming: Incoming,
    wss: WebSocketServer,
    cannelsCtrl: ChannelsCtrl,
    type: string,
  ) {
    const sendDataStr = JSON.stringify(sendData);

    wss.clients.forEach(async (client: WebSocket) => {
      const user = client.user as WebSocketUser;
      log(`broadcast:`, user.name);

      if (!this.canBroadcast(client, sender.channel)) return;

      log(`canBroadcast:`, user.name);

      let sendable = true;

      // メッセージの時だけ、送信条件の検査
      if (type === 'message') {
        sendable = await cannelsCtrl
          .getChannel(sender.channel)
          .callbackCheckSend(sender, user, incoming);
      }

      if (!sendable) return;

      log(`sendable:`, user.name);

      client.send(sendDataStr);
    });
  }

  /** 送信用ユーザーに変換 */
  toBroadcastUser(user: WebSocketUser) {
    return {
      name: user.name,
      id: user.id,
    };
  }
}
