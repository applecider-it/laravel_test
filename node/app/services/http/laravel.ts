import { type WebSocket } from 'ws';

import { log } from '@/services/system/log.ts';
import { postWithAuth } from '@/services/http/sender';

import { WebSocketUser, AnyJson } from '@/types/types';

/**
 * 認証情報付きで、LaravelにAPI送信する。
 */
export async function sendToLaravel(
  sender: WebSocketUser,
  params: AnyJson,
  uri: string
) {
  log('sendToLaravel', params, uri, sender.info.name);

  const url = `http://${process.env.APP_LARAVEL_API_HOST}${uri}`;

  log(`send: ${url} token ${sender.token}`);

  return postWithAuth(url, sender.token || '', params);
}
