import { log } from '@/services/system/log.js';

import { WebSocketUser, Incoming } from '@/services/web-socket/types.js';

import BaseCannnel from './BaseCannnel.js';
import Test from './chat-cannnel/Test.js';

/**
 * チャットチャンネル
 *
 * target_user_idが指定されているときは、対象のuser_idにだけ送信。
 */
export default class ChatCannnel extends BaseCannnel {
  test;

  constructor() {
    super();

    this.test = new Test();
  }

  /** メッセージ取得時のデータ生成 */
  async callbackCreateData(sender: WebSocketUser, incoming: Incoming) {
    await this.test.callbackTest(sender, incoming);

    return {
      message: incoming.data.message,
      name: incoming.data.name,
    };
  }

  /** メッセージをブロードキャストしていいか返す */
  async callbackCheckSend(
    sender: WebSocketUser,
    user: WebSocketUser,
    incoming: Incoming
  ) {
    const targetUserId = incoming.data.target_user_id ?? null;

    log('targetUserId', [targetUserId], user);

    // target_user_idが指定されているときは、対象のuser_idにだけ送信。
    if (targetUserId && targetUserId !== user.id) return false;

    return true;
  }
}
