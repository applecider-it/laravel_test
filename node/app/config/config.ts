import { loadEnv } from '@/services/system/env.js';

loadEnv();

/** アプリケーションの設定 */
export const appConfig = {
  webSocket: {
    host: process.env.APP_WS_HOST as string,
    port: Number(process.env.APP_WS_PORT),

    /** システムから送信するときの送信タイプ */
    systemSendType: 'redis',
    //systemSendType: 'websocket',
  },

  webSocketInfo: {
    /** WebSocketサーバーのシステムからの送信名 */
    systemName: 'System',
  },

  jwtSecret: process.env.APP_WS_JWT_SECRET as string,

  redis: {
    url: process.env.APP_REDIS_URL as string,

    /** プレフィックス */
    prefix: process.env.APP_REDIS_PREFIX as string,
  },

  /** WebSocketのRedis連携 */
  webSocketRedis: {
    /** WebSocketサーバーのRedis Pub/Subで利用するチャンネル */
    channel: 'broadcast',
  },

  /** Laravelの情報 */
  laravel: {
    host: process.env.APP_LARAVEL_API_HOST as string,
  },

  /** PUSH通知 */
  push: {
    publicKey: process.env.APP_VAPID_PUBLIC_KEY as string,
    privateKey: process.env.APP_VAPID_PRIVATE_KEY as string,
    mailto: 'you@example.com',
  },
} as const;
