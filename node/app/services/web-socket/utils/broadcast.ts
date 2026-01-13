import { log } from '@/services/system/log.js';

import { WebSocket, type WebSocketServer } from 'ws';

import { WebSocketUser, Incoming, BroadcastSendData } from '../types.js';

import type ChannelsCtrl from '../server/ChannelsCtrl.js';

/** 特定のチャンネルに、全体送信できるクライアントか確認 */
export function canBroadcast(client: WebSocket, channel: string) {
  const user = client.user as WebSocketUser;

  if (client.readyState === WebSocket.OPEN) {
    if (user.channel == channel) {
      return true;
    }
  }

  return false;
}

/**
 * 同じチャンネルのユーザー公開情報一覧
 */
export function getSameChannelUsers(wss: WebSocketServer, ws: WebSocket) {
  const target = ws.user as WebSocketUser;
  const list: any[] = [];
  wss.clients.forEach(async (client: WebSocket) => {
    const user = client.user as WebSocketUser;

    if (!canBroadcast(client, target.channel)) return;

    list.push({
      id: user.id,
      name: user.name,
    });
  });

  return list;
}

/** 同じチャンネルに全体送信 */
export function broadcastSameChannel(
  sendData: BroadcastSendData,
  sender: WebSocketUser,
  incoming: Incoming,
  wss: WebSocketServer,
  cannelsCtrl: ChannelsCtrl,
  type: string
) {
  const sendDataStr = JSON.stringify(sendData);

  wss.clients.forEach(async (client: WebSocket) => {
    const user = client.user as WebSocketUser;
    log(`broadcast:`, user.name);

    if (!canBroadcast(client, sender.channel)) return;

    log(`canBroadcast:`, user.name);

    let sendable = true;

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
export function toBroadcastUser(user: WebSocketUser) {
  return {
    name: user.name,
    id: user.id,
  };
}
