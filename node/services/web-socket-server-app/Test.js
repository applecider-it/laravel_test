/**
 * テスト用クラス
 */
export default class Test {
  /** 実験的にnodeからlaravelにapi送信するロジック */
  async callbackTest(ws, incoming) {
    if (ws.user.id === "system") return;

    try {
      const url = `${process.env.LARAVEL_API_URL}/api/chat/callback_test`;

      console.log(`send: ${url} token ${ws.user.token}`);

      const response = await fetch(url, {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${ws.user.token || ''}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ content: incoming.message }),
      });

      if (!response.ok) {
        console.error('APIエラー:', response.status, response.statusText);
        return;
      }

      const data = await response.json();
      console.log('Laravelからの返却:', data);
    } catch (err) {
      console.error('Laravel API error:', err);
    }
  }
}
