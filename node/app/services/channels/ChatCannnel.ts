import { canBroadcast } from '@/services/web-socket/broadcast.ts';
import { log } from '@/services/system/log.ts';

import Test from './chat-cannnel/Test.ts';

const CHANNEL_ID = 'chat';

/**
 * チャットチャンネル
 */
export default class ChatCannnel {
  test;

  constructor() {
    this.test = new Test();
  }

  /** メッセージ取得時 */
  async handleMessage(wss: any, ws: any, incoming: any) {
    await this.test.callbackTest(ws, incoming);

    const data = {
      type: 'newChat',
      info: ws.user.info,
      id: ws.user.id,
      message: incoming.message,
    };

    this.broadcast(wss, data);
  }

  /** 全体送信 */
  private broadcast(wss: any, data: any) {
    const str = JSON.stringify(data);

    wss.clients.forEach((client: any) => {
      log(`broadcast:`, client.user.info);

      if (canBroadcast(client, CHANNEL_ID)) {
        log(`send:`,  client.user.info);
        client.send(str);
      }
    });
  }
}
