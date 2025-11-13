import WebSocket from 'ws';

/** 特定のチャンネルに、全体送信できるクライアントか確認 */
export function canBroadcast(client: any, channel: string) {
  if (client.readyState === WebSocket.OPEN) {
    if (client.user.id !== 'system' && client.user.channel == channel) {
      return true
    }
  }

  return false;
}