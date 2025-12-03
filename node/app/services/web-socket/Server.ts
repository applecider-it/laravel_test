import { WebSocket, WebSocketServer, type RawData } from 'ws';
import { IncomingMessage } from 'http';
import Redis from 'ioredis';

import { log } from '@/services/system/log.ts';

import ChatCannnel from '@/services/channels/ChatCannnel.ts';
import TweetCannnel from '@/services/channels/TweetCannnel.ts';

import Auth from './server/Auth.ts';

import { WebSocketUser, Incoming } from '@/types/types';

import { WS_SYSTEM_ID, WS_SYSTEM_NAME } from './system';

type Options = {
  host: string;
  port: number;
};

type Channels = {
  chat: ChatCannnel;
  tweet: TweetCannnel;
};

/**
 * WebSocket サーバー管理
 */
export default class Server {
  /** 権限管理サブクラス */
  auth;
  /** Pub/Subで利用するRedisクラス */
  redis;
  /** 全てのチャンネルクラスを集めたハッシュ */
  channels: Channels;
  /** WebSockerサーバーインスタンス */
  wss: WebSocketServer;
  redisKey;

  constructor({ host = '0.0.0.0', port = 8080 }: Options) {
    const redisPrefix = process.env.APP_REDIS_PREFIX as string;
    this.redisKey = redisPrefix + 'broadcast';

    this.auth = new Auth();
    this.redis = new Redis({ host: '127.0.0.1', port: 6379, db: 0 });

    this.channels = {
      chat: new ChatCannnel(),
      tweet: new TweetCannnel(),
    };

    this.wss = new WebSocketServer({ host, port });

    this.wss.on('connection', (ws, req) => this.handleConnection(ws, req));

    // Redisの連携用チャンネルをsubscribeする
    this.redis.subscribe(this.redisKey, (err, count) =>
      this.handleRedisSubscribe(err, count)
    );

    this.redis.on('message', (channel, message) =>
      this.handleRedisMessage(channel, message)
    );

    log(`WebSocket server running on ws://${host}:${port}`);
  }

  /** コネクション時 */
  handleConnection(ws: WebSocket, req: IncomingMessage) {
    const user = this.auth.authenticate(req);

    if (!user) {
      log('invalid authenticate');
      ws.close();
      return;
    }

    ws.user = user;
    log(`Authenticated:`, user.info);

    ws.on('message', (msg) => this.handleMessage(ws, msg));

    ws.on('close', () => {
      log(`Disconnected: ${ws.user?.info.name}`);
    });
  }

  /** メッセージ取得時 */
  async handleMessage(senderWs: WebSocket, msg: RawData) {
    let incoming: Incoming;
    const sender = senderWs.user as WebSocketUser;

    try {
      incoming = JSON.parse(String(msg));
    } catch {
      return;
    }

    // これがないとLaravelでrecieveしたときに止まる
    // Laravelでrecieveしない場合はいらない
    senderWs.send(JSON.stringify({ type: 'sended', ok: true }));

    await this.sendCommon(sender, incoming);
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

    await this.sendCommon(sender, incoming);
  }

  /** WebSocket, Redis共通の送信処理 */
  async sendCommon(sender: WebSocketUser, incoming: Incoming) {
    log('incoming', incoming);
    log('sender', sender);

    const channel = sender.channel as 'chat' | 'tweet';

    const handler = this.channels[channel];
    if (handler) {
      handler.handleMessage(this.wss, sender, incoming);
    }
  }
}
