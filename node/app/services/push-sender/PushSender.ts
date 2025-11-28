import webpush from 'web-push';
import Redis from 'ioredis';
import { send } from 'process';

// Push データの型定義
interface PushData {
  endpoint: string;
  p256dh: string;
  auth: string;
  message: string;
}

/**
 * プッシュ通知送信管理クラス
 */
export default class PushSender {
  mailto;
  publicKey;
  privateKey;
  redisKey;

  constructor(mailto: string, publicKey: string, privateKey: string) {
    this.mailto = mailto;
    this.publicKey = publicKey;
    this.privateKey = privateKey;

    this.redisKey = 'laravel-test-database-push_queue';
  }

  /** プッシュ通知送信起動 */
  async execPushSender() {
    this.setupWebPush();

    await this.pushAll();
  }

  /** プッシュ通知セットアップ */
  setupWebPush() {
    // VAPID キー設定
    webpush.setVapidDetails(this.mailto, this.publicKey, this.privateKey);
  }

  /** Redisにあるデータをすべて送信 */
  async pushAll() {
    // Redis サーバに接続
    const redis = new Redis();

    while (true) {
      const item = await redis.lpop(this.redisKey);
      if (!item) break; // キューが空になったら終了

      await this.pushOne(item);
    }
  }

  /** Redisにあるデータを１つ送信 */
  async pushOne(item: string) {
    let data: PushData;

    try {
      data = JSON.parse(item) as PushData;
    } catch (err) {
      console.error('Invalid JSON:', item, err);
      return;
    }

    try {
      await webpush.sendNotification(
        {
          endpoint: data.endpoint,
          keys: { p256dh: data.p256dh, auth: data.auth },
        },
        JSON.stringify({ title: data.message })
      );
      console.log('Sent:', data.endpoint);
    } catch (err: any) {
      console.error('Failed:', data.endpoint, err.statusCode || err);
    }
  }
}
