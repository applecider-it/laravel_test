/** 認証情報付きで、LaravelにAPI送信する */
export async function sendToLaravel(ws, params, uri) {
  let data = null;

  console.log('sendToLaravel', params, uri, ws.user.name);

  try {
    const url = `${process.env.LARAVEL_API_URL}${uri}`;

    console.log(`send: ${url} token ${ws.user.token}`);

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

  return {
    data
  };
}
