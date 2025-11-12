import jwt from 'jsonwebtoken';

/**
 * 認証管理
 */
export default class Auth {
  /** 認証 */
  authenticate(req) {
    const params = new URLSearchParams(req.url.replace('/?', ''));
    const token = params.get('token');

    console.log(`token: ${token}`);

    if (!token) return null;
    console.log(`WS_JWT_SECRET: ${process.env.WS_JWT_SECRET}`);

    try {
      const payload = jwt.verify(token, process.env.WS_JWT_SECRET);

      return {
        id: payload.sub,
        name: payload.name,
        token,
      };
    } catch (e) {
      console.error(e);
      return null;
    }
  }
}
