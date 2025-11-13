import WebSocket from 'ws';

import { canBroadcast } from '#services/web-socket/broadcast.js';
import { log } from '#services/system/log.js';

import Test from './chat-cannnel/Test.js';

/**
 * チャットチャンネル
 */
export default class ChatCannnel {
  constructor() {
    this.test = new Test();
  }

  /** メッセージ取得時 */
  async handleMessage(wss, ws, incoming) {
    await this.test.callbackTest(ws, incoming);

    const data = {
      type: 'newChat',
      user: ws.user.name,
      user_id: ws.user.id,
      message: incoming.message,
    };

    this.#broadcast(wss, data);
  }

  /** 全体送信 */
  #broadcast(wss, data) {
    const str = JSON.stringify(data);

    wss.clients.forEach((client) => {
      log(`broadcast: ${client.user?.name}`);

      if (canBroadcast(client, 'chat')) {
        log(`send: ${client.user?.name}`);
        client.send(str);
      }
    });
  }
}
