import WebSocket from 'ws';

import Test from './chat-cannnel/Test.js';

import { canBroadcast } from '#services/broadcast.js';

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
      console.log(`broadcast: ${client.user?.name}`);

      if (canBroadcast(client, 'chat')) {
          console.log(`send: ${client.user?.name}`);
          client.send(str);
      }
    });
  }
}
