import { WebSocketUser, Incoming } from '../../types.js';

import { appConfig } from '@/config/config.js';

/** システムからの送信と判別するためのID。 */
const WS_SYSTEM_ID = 0;

/** システムのWebSocketUser */
export function getSystemUser(channel: string) {
  const sender: WebSocketUser = {
    id: WS_SYSTEM_ID,
    name: appConfig.webSocketInfo.systemName,
    token: '',
    channel: channel,
  };

  return sender;
}
