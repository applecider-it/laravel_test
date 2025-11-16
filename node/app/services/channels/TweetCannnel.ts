import { canBroadcast } from '@/services/web-socket/broadcast.ts';
import { log } from '@/services/system/log.ts';

const CHANNEL_ID = 'tweet';

/**
 * ツイートチャンネル
 */
export default class TweetCannnel {
  constructor() {
  }

  /** メッセージ取得時 */
  async handleMessage(wss: any, ws: any, incoming: any) {
    const sendData = {
      type: 'newTweet',
      info: ws.user.info,
      id: ws.user.id,
      data: {
        tweet: incoming.data.tweet,
      },
    };

    this.broadcast(wss, sendData);
  }

  /** 全体送信 */
  private broadcast(wss: any, sendData: any) {
    const sendDataStr = JSON.stringify(sendData);

    wss.clients.forEach((client: any) => {
      log(`broadcast:`, client.user.info);

      if (!canBroadcast(client, CHANNEL_ID)) return;

      log(`send:`, client.user.info);

      client.send(sendDataStr);
    });
  }
}
