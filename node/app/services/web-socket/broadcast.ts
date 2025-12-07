import { WebSocket } from 'ws';

import { WebSocketUser } from './types';

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
