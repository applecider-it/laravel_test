import { sendToLaravel } from '#services/system/laravel.js';
import { log } from '#services/system/log.js';

/**
 * チャットチャンネルのテスト用クラス
 */
export default class Test {
  /** 実験的にnodeからlaravelにapi送信するロジック */
  async callbackTest(ws, incoming) {
    if (ws.user.id === 'system') return;

    const params = { content: incoming.message };
    const uri = '/api/chat/callback_test';

    const data = await sendToLaravel(ws, params, uri);

    log('Laravelからの返却:', data);
  }
}
