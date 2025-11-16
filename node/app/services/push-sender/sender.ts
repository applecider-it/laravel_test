import webpush from 'web-push';
import Redis from 'ioredis';

export async function senderMain(): Promise<void> {
  // Redis サーバに接続
  const redis = new Redis();

  console.log(
    'process.env.APP_VAPID_PUBLIC_KEY',
    process.env.APP_VAPID_PUBLIC_KEY
  );

  // VAPID キー設定
  webpush.setVapidDetails(
    'mailto:you@example.com',
    process.env.APP_VAPID_PUBLIC_KEY as string,
    process.env.APP_VAPID_PRIVATE_KEY as string
  );

  // Push データの型定義
  interface PushData {
    endpoint: string;
    p256dh: string;
    auth: string;
    message: string;
  }
  while (true) {
    const item = await redis.lpop('laravel-test-database-push_queue');
    if (!item) break; // キューが空になったら終了

    let data: PushData;
    try {
      data = JSON.parse(item) as PushData;
    } catch (err) {
      console.error('Invalid JSON:', item, err);
      continue;
    }

    try {
      await webpush.sendNotification(
        {
          endpoint: data.endpoint,
          keys: { p256dh: data.p256dh, auth: data.auth },
        },
        JSON.stringify({ title: 'From Node' })
      );
      console.log('Sent:', data.endpoint);
    } catch (err: any) {
      console.error('Failed:', data.endpoint, err.statusCode || err);
    }
  }
}
