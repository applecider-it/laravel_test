import Redis from 'ioredis';

import { log } from '@/services/system/log.ts';

import { WebSocketUser, Incoming } from '../types';

import { WS_SYSTEM_ID, WS_SYSTEM_NAME } from '../system';

/**
 * WebSocket サーバーのRedis管理
 */
export default class RedisCtrl {
  /** Pub/Subで利用するRedisクラス */
  redis;
  redisKey;

  constructor(callback: Function) {
    const redisPrefix = process.env.APP_REDIS_PREFIX as string;
    this.redisKey = redisPrefix + 'broadcast';

    this.redis = new Redis({ host: '127.0.0.1', port: 6379, db: 0 });

    // Redisの連携用チャンネルをsubscribeする
    this.redis.subscribe(this.redisKey, (err, count) =>
      this.handleRedisSubscribe(err, count)
    );

    this.redis.on('message', async (channel, message) => {
      const ret = await this.handleRedisMessage(channel, message);
      if (!ret) return;
      const { sender, incoming } = ret;
      await callback(sender, incoming);
    });
  }

  /** Redisサブスクライブ時 */
  handleRedisSubscribe(err: Error | null | undefined, count: unknown) {
    if (err) console.error(err);
    else console.log(`Subscribed to ${count} channel(s)`);
  }

  /** Redisメッセージ受信時 */
  async handleRedisMessage(redisChannel: string, message: string) {
    console.log(`Received from Redis: ${redisChannel}: ${message}`);

    let ret = null;
    try {
      ret = JSON.parse(message);
    } catch {
      return;
    }

    const sender: WebSocketUser = {
      id: WS_SYSTEM_ID,
      info: {
        name: WS_SYSTEM_NAME,
      },
      token: '',
      channel: ret.channel,
      channelData: null,
    };

    const incoming: Incoming = {
      data: ret.data,
    };

    log('incoming', incoming);
    log('sender', sender);

    return {sender, incoming};
  }
}
