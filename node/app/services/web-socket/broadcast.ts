import WebSocket from 'ws';

import { WS_SYSTEM_ID } from '@/services/web-socket/system.ts';

/** 特定のチャンネルに、全体送信できるクライアントか確認 */
export function canBroadcast(client: any, channel: string) {
  if (client.readyState === WebSocket.OPEN) {
    if (client.user.id !== WS_SYSTEM_ID && client.user.channel == channel) {
      return true;
    }
  }

  return false;
}
