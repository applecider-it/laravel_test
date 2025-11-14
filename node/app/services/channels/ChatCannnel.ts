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

    const targetToken = incoming.data.target_token ?? null;

    log(`targetToken: `, targetToken);

    const sendData = {
      type: 'newChat',
      info: ws.user.info,
      id: ws.user.id,
      data: {
        message: incoming.data.message,
      },
    };

    this.broadcast(wss, sendData, targetToken);
  }

  /** 全体送信 */
  private broadcast(wss: any, sendData: any, targetToken: string | null) {
    const sendDataStr = JSON.stringify(sendData);

    wss.clients.forEach((client: any) => {
      log(`broadcast:`, client.user.info);

      if (!canBroadcast(client, CHANNEL_ID)) return;

      log(`send:`, client.user.info);

      if (targetToken && targetToken !== client.user.token) return;

      client.send(sendDataStr);
    });
  }
}
