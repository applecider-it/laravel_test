import webpush from 'web-push';
import Redis from 'ioredis';

import { log } from '@/services/system/log.js';

// Push データの型定義
interface PushData {
  endpoint: string;
  p256dh: string;
  auth: string;
  id: number;
  message: string;
  options: any;
}

/**
 * プッシュ通知送信管理クラス
 */
export default class PushSender {
  mailto;
  publicKey;
  privateKey;
  redisKey;
  redisKeyResult;

  constructor(mailto: string, publicKey: string, privateKey: string) {
    this.mailto = mailto;
    this.publicKey = publicKey;
    this.privateKey = privateKey;

    const redisPrefix = process.env.APP_REDIS_PREFIX as string;
    this.redisKey = redisPrefix + 'push_queue';
    this.redisKeyResult = redisPrefix + 'push_queue_result';
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

      await this.pushOne(item, redis);
    }
  }

  /** Redisにあるデータを１つ送信 */
  async pushOne(item: string, redis: Redis) {
    let data: PushData;

    try {
      data = JSON.parse(item) as PushData;
    } catch (err) {
      console.error('Invalid JSON:', item, err);
      return;
    }

    log('id:', data.id);

    let status = false;
    try {
      await webpush.sendNotification(
        {
          endpoint: data.endpoint,
          keys: { p256dh: data.p256dh, auth: data.auth },
        },
        JSON.stringify({
          title: data.message,
          options: data.options,
        })
      );

      status = true;

      log('Sent:', data.endpoint);
    } catch (err: any) {
      log('Failed:', data.endpoint, err);
      //console.error('Failed:', data.endpoint, err.statusCode || err);
    }

    // 結果をredisに保存
    const cnt = await redis.rpush(
      this.redisKeyResult,
      JSON.stringify({
        id: data.id,
        status: status,
      })
    );

    log('redis cnt:', cnt);
  }
}
