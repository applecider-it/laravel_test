import { loadEnv } from '#services/system/env.js';
import Server from '#services/web-socket/Server.js';

/** アプリケーションを開始する */
export function startApplication() {
  loadEnv();

  // サーバー起動
  const app = new Server({
    host: '0.0.0.0',
    port: 8080,
  });
}
