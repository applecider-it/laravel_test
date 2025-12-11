import { WebSocketUser, Incoming } from '@/services/web-socket/types.js';
import { BroadcastDataTweet } from './types.js';

/**
 * ツイートチャンネル
 */
export default class TweetCannnel {
  constructor() {}

  /** メッセージ取得時のデータ生成 */
  async callbackCreateData(sender: WebSocketUser, incoming: Incoming) {
    return {
      tweet: incoming.data.tweet,
    } as BroadcastDataTweet;
  }

  /** メッセージをブロードキャストしていいか返す */
  async callbackCheckSend(
    sender: WebSocketUser,
    user: WebSocketUser,
    incoming: Incoming
  ) {
    return true;
  }
}
