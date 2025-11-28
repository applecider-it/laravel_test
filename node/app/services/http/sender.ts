import { AnyJson } from '@/types/types';

/**
 * 認証情報付きで、HTTPのPOST送信する。
 */
export async function postWithAuth(
  url: string,
  token: string,
  params: AnyJson
) {
  const ret = {
    data: null,
    status: false,
  };

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(params),
    });

    if (!response.ok) {
      console.error('APIエラー:', response.status, response.statusText);
      return ret;
    }

    ret.data = await response.json();
    ret.status = true;
  } catch (err) {
    console.error('Laravel API error:', err);

    return ret;
  }

  return ret;
}
