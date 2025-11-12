import dotenv from 'dotenv';
import { dirname } from 'path';
import { fileURLToPath } from 'url';

import WebSocketServerApp from './WebSocketServerApp.js';

import { log } from '#services/log.js';

/** .env読み込み */
function loadEnv() {
  log('import.meta.url', import.meta.url);
  const dir = dirname(dirname(fileURLToPath(import.meta.url)));
  dotenv.config({ path: `${dir}/.env` });
}

/** アプリケーションを開始する */
export function startApplication() {
  loadEnv();

  // サーバー起動
  const app = new WebSocketServerApp({
    host: '0.0.0.0',
    port: 8080,
  });
}
