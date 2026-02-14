import { WebSocketUser, Incoming } from '../types.js';

import { appConfig } from '@/config/config.js';

/**
 * WebSocket サーバーのSystem管理
 */
export default class SystemCtrl {
  /** システムからの送信と判別するためのID。 */
  private WS_SYSTEM_ID = 0;

  /** システムのWebSocketUser */
  getSystemUser(channel: string) {
    const sender: WebSocketUser = {
      id: this.WS_SYSTEM_ID,
      name: appConfig.webSocketInfo.systemName,
      token: '',
      channel: channel,
    };

    return sender;
  }
}
