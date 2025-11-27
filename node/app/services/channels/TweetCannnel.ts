import { type WebSocket, type WebSocketServer } from 'ws';

import { canBroadcast } from '@/services/web-socket/broadcast.ts';
import { log } from '@/services/system/log.ts';

import { WebSocketUser, Incoming } from '@/types/types';

const CHANNEL_ID = 'tweet';

type SendData = {
  type: string;
  info: any;
  id: number | string;
  data: {
    tweet: any;
  };
};

/**
 * ツイートチャンネル
 */
export default class TweetCannnel {
  constructor() {
  }

  /** メッセージ取得時 */
  async handleMessage(wss: WebSocketServer, senderWs: WebSocket, incoming: Incoming) {
    const sender = senderWs.user as WebSocketUser
    const sendData: SendData = {
      type: 'newTweet',
      info: sender.info,
      id: sender.id,
      data: {
        tweet: incoming.data.tweet,
      },
    };

    log('TweetCannnel::handleMessage  sender', sender);
    log('TweetCannnel::handleMessage  sendData', sendData);

    this.broadcast(wss, sendData);
  }

  /** 全体送信 */
  private broadcast(wss: WebSocketServer, sendData: SendData) {
    const sendDataStr = JSON.stringify(sendData);

    wss.clients.forEach((client: WebSocket) => {
      const user = client.user as WebSocketUser
      log(`broadcast:`, user.info);

      if (!canBroadcast(client, CHANNEL_ID)) return;

      log(`send:`, user.info);

      client.send(sendDataStr);
    });
  }
}
