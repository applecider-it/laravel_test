import jwt from 'jsonwebtoken';
import { type IncomingMessage } from 'http';

import { log } from '@/services/system/log.ts';

import { WebSocketUser } from '@/types/types';

/**
 * 認証管理
 */
export default class Auth {
  /**
   * JWTから認証してユーザー情報を返す
   */
  authenticate(req: IncomingMessage): WebSocketUser | null {
    const url = req.url as string;

    const params = new URLSearchParams(url.replace('/?', ''));
    const token = params.get('token');
    const channel = params.get('channel') as string;

    log(`token: ${token}`);
    log(`channel: ${channel}`);

    if (!token) return null;

    let payload: any = null;

    try {
      payload = jwt.verify(token, process.env.APP_WS_JWT_SECRET!);
    } catch (e) {
      console.error(e);
      return null;
    }

    return {
      id: payload.sub,
      info: {
        name: payload.name,
      },
      token,
      channel,
      channelData: {},
    };
  }
}
