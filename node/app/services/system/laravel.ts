
import { log } from '@/services/system/log.ts';

/** 
 * 認証情報付きで、LaravelにAPI送信する。
 * 
 * エラー発生時は、トレースしてからnullを返す。
 */
export async function sendToLaravel(ws: any, params: any, uri: string) {
  let data = null;

  log('sendToLaravel', params, uri, ws.user.name);

  try {
    const url = `http://${process.env.APP_LARAVEL_API_HOST}${uri}`;

    log(`send: ${url} token ${ws.user.token}`);

    const response = await fetch(url, {
      method: 'POST',
      headers: {
        Authorization: `Bearer ${ws.user.token || ''}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(params),
    });

    if (!response.ok) {
      console.error('APIエラー:', response.status, response.statusText);
      return null;
    }

    data = await response.json();
  } catch (err) {
    console.error('Laravel API error:', err);

    return null;
  }

  // エラー時と区別をつけられるようにオブジェクトにして返す
  return {
    data
  };
}
