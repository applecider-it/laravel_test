import { canBroadcast } from '@/services/web-socket/broadcast.ts';
import { log } from '@/services/system/log.ts';

import Test from './chat-cannnel/Test.ts';

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
      user: ws.user.name,
      user_id: ws.user.id,
      message: incoming.message,
    };

    this.broadcast(wss, data);
  }

  /** 全体送信 */
  private broadcast(wss: any, data: any) {
    const str = JSON.stringify(data);

    wss.clients.forEach((client: any) => {
      log(`broadcast: ${client.user?.name}`);

      if (canBroadcast(client, 'chat')) {
        log(`send: ${client.user?.name}`);
        client.send(str);
      }
    });
  }
}
