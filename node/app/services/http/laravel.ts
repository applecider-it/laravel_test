import { log } from '@/services/system/log.js';
import { postWithAuth } from '@/services/http/sender.js';

import { AnyJson } from '@/types/types.js';

import { WebSocketUser } from '@/services/web-socket/types.js';

import { appConfig } from '@/config/config.js';

/**
 * 認証情報付きで、LaravelにAPI送信する。
 */
export async function sendToLaravel(
  sender: WebSocketUser,
  params: AnyJson,
  uri: string
) {
  log('sendToLaravel', params, uri, sender.name);

  const url = `http://${appConfig.laravel.host}${uri}`;

  log(`send: ${url} token ${sender.token}`);

  return postWithAuth(url, sender.token || '', params);
}
