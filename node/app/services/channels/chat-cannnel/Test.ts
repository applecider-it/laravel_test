import { sendToLaravel } from '@/services/system/laravel.js';
import { log } from '@/services/system/log.ts';

import { WS_SYSTEM_ID } from '@/services/web-socket/system.ts';

/**
 * チャットチャンネルのテスト用クラス
 */
export default class Test {
  /** 実験的にnodeからlaravelにapi送信するロジック */
  async callbackTest(ws: any, incoming: any) {
    if (ws.user.id === WS_SYSTEM_ID) return;

    const params = { content: incoming.data.message };
    const uri = '/api/chat/callback_test';

    const data = await sendToLaravel(ws, params, uri);

    log('Laravelからの返却:', data);
  }
}
