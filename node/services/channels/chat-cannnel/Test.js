import { sendToLaravel } from '#services/laravel.js';

import { log } from '#services/log.js';

/**
 * テスト用クラス
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
