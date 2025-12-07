import { type WebSocket } from 'ws';

import { sendToLaravel } from '@/services/http/laravel.js';
import { log } from '@/services/system/log.ts';

import { WebSocketUser, Incoming } from '@/services/web-socket/types';

/**
 * チャットチャンネルのテスト用クラス
 */
export default class Test {
  /** 実験的にnodeからlaravelにapi送信するロジック */
  async callbackTest(sender: WebSocketUser, incoming: Incoming) {
    const params = { content: incoming.data.message };
    const uri = '/api/development/chat_callback_test';

    const data = await sendToLaravel(sender, params, uri);

    log('Laravelからの返却:', data);
  }
}
