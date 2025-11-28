import { WebSocket } from 'ws';

import { WS_SYSTEM_ID } from '@/services/web-socket/system.ts';

import { WebSocketUser } from '@/types/types';

/** 特定のチャンネルに、全体送信できるクライアントか確認 */
export function canBroadcast(client: WebSocket, channel: string) {
  const user = client.user as WebSocketUser;

  if (client.readyState === WebSocket.OPEN) {
    if (user.id !== WS_SYSTEM_ID && user.channel == channel) {
      return true;
    }
  }

  return false;
}
