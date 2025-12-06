import { log } from '@/services/system/log.ts';

import { WebSocketUser, Incoming } from '@/services/web-socket/types';

import { BroadcastDataChat } from './types.ts';
import Test from './chat-cannnel/Test.ts';

/**
 * チャットチャンネル
 *
 * target_user_idが指定されているときは、対象のuser_idにだけ送信。
 */
export default class ChatCannnel {
  test;

  constructor() {
    this.test = new Test();
  }

  /** メッセージ取得時のデータ生成 */
  async callbackCreateData(sender: WebSocketUser, incoming: Incoming) {
    await this.test.callbackTest(sender, incoming);

    return {
      message: incoming.data.message,
    } as BroadcastDataChat;
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
