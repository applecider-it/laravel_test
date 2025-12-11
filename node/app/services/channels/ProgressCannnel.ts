import { WebSocketUser, Incoming } from '@/services/web-socket/types.js';
import { BroadcastDataProgress } from './types.js';

/**
 * 経過表示チャンネル
 */
export default class ProgressCannnel {
  constructor() {}

  /** メッセージ取得時のデータ生成 */
  async callbackCreateData(sender: WebSocketUser, incoming: Incoming) {
    return {
      info: incoming.data.info,
    } as BroadcastDataProgress;
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
