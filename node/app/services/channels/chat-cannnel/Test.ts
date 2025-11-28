import { type WebSocket } from 'ws';

import { sendToLaravel } from '@/services/system/laravel.js';
import { log } from '@/services/system/log.ts';

import { WS_SYSTEM_ID } from '@/services/web-socket/system.ts';

import { WebSocketUser, Incoming } from '@/types/types';

/**
 * チャットチャンネルのテスト用クラス
 */
export default class Test {
  /** 実験的にnodeからlaravelにapi送信するロジック */
  async callbackTest(senderWs: WebSocket, incoming: Incoming) {
    const sender = senderWs.user as WebSocketUser

    if (sender.id === WS_SYSTEM_ID) return;

    const params = { content: incoming.data.message };
    const uri = '/api/development/chat_callback_test';

    const data = await sendToLaravel(senderWs, params, uri);

    log('Laravelからの返却:', data);
  }
}
