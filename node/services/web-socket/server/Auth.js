import jwt from 'jsonwebtoken';

import { log } from '#services/system/log.js';

/**
 * 認証管理
 */
export default class Auth {
  /**
   * JWTから認証してユーザー情報を返す
   */
  authenticate(req) {
    const params = new URLSearchParams(req.url.replace('/?', ''));
    const token = params.get('token');
    const channel = params.get('channel');

    log(`token: ${token}`);
    log(`channel: ${channel}`);

    if (!token) return null;
    log(`WS_JWT_SECRET: ${process.env.WS_JWT_SECRET}`);

    let payload = null;

    try {
      payload = jwt.verify(token, process.env.WS_JWT_SECRET);
    } catch (e) {
      console.error(e);
      return null;
    }

    return {
      id: payload.sub,
      name: payload.name,
      token,
      channel,
      channelData: {},
    };
  }
}
