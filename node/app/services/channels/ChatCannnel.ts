import { type WebSocket, type WebSocketServer } from 'ws';

import { canBroadcast } from '@/services/web-socket/broadcast.ts';
import { log } from '@/services/system/log.ts';

import { WebSocketUser, Incoming } from '@/types/types';

import Test from './chat-cannnel/Test.ts';

const CHANNEL_ID = 'chat';

/** ブロードキャスト用送信データ */
type SendData = {
  type: string;
  info: any;
  id: number | string;
  data: {
    message: any;
  };
};

/**
 * チャットチャンネル
 * 
 * target_tokenが指定されているときは、対象のtarget_tokenにだけ送信。
 */
export default class ChatCannnel {
  test;

  constructor() {
    this.test = new Test();
  }

  /** メッセージ取得時 */
  async handleMessage(wss: WebSocketServer, senderWs: WebSocket, incoming: Incoming) {
    await this.test.callbackTest(senderWs, incoming);

    const targetToken = incoming.data.target_token ?? null;
    const sender = senderWs.user as WebSocketUser

    log(`targetToken: `, targetToken);

    const sendData: SendData = {
      type: 'newChat',
      info: sender.info,
      id: sender.id,
      data: {
        message: incoming.data.message,
      },
    };

    this.broadcast(wss, sendData, targetToken);
  }

  /** 全体送信 */
  private broadcast(wss: WebSocketServer, sendData: SendData, targetToken: string | null) {
    const sendDataStr = JSON.stringify(sendData);

    wss.clients.forEach((client: WebSocket) => {
      const user = client.user as WebSocketUser
      log(`broadcast:`, user.info);

      if (!canBroadcast(client, CHANNEL_ID)) return;

      log(`send:`, user.info);

      // target_tokenが指定されているときは、対象のtarget_tokenにだけ送信
      if (targetToken && targetToken !== user.token) return;

      client.send(sendDataStr);
    });
  }
}
