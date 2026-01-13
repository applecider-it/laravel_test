import Redis from 'ioredis';

import { log } from '@/services/system/log.js';

import { WebSocketUser, Incoming } from '../types.js';

import { getSystemUser } from '../utils/system.js';

import { appConfig } from '@/config/config.js';

/**
 * WebSocket サーバーのRedis管理
 */
export default class RedisCtrl {
  /** Pub/Subで利用するRedisクラス */
  redis;
  redisPub;
  redisKey;

  constructor(callback: Function, redisUrl: string) {
    this.redisKey = appConfig.redis.prefix + appConfig.webSocketRedis.channel;

    this.redis = new Redis(redisUrl);
    this.redisPub = new Redis(redisUrl);

    // Redisの連携用チャンネルをsubscribeする
    this.redis.subscribe(this.redisKey, (err, count) =>
      this.handleRedisSubscribe(err, count)
    );

    this.redis.on('message', async (channel, message) => {
      const ret = await this.handleRedisMessage(channel, message);
      if (!ret) return;
      const { sender, incoming, type } = ret;
      await callback(sender, incoming, type);
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

    const sender = getSystemUser(ret.channel);

    const incoming: Incoming = {
      data: ret.data,
    };

    log('incoming', incoming);
    log('sender', sender);

    return { sender, incoming, type: ret.type as string };
  }

  /** パブリッシュする */
  async publish(channel: string, data: any, type: string) {
    const sendData = {
      channel,
      data,
      type,
    };
    await this.redisPub.publish(this.redisKey, JSON.stringify(sendData));
  }
}
