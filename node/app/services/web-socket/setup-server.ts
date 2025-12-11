import { loadEnv } from '@/services/system/env.js';
import Server from '@/services/web-socket/Server.js';

import { log } from '@/services/system/log.js';

/** アプリケーションを開始する */
export function startApplication(): void {
  loadEnv();

  // サーバー起動
  const app = new Server();
}

startApplication();
