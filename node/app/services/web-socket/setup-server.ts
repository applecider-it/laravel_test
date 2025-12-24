import { initApp } from '@/services/system/init.js';
import Server from '@/services/web-socket/Server.js';

import { log } from '@/services/system/log.js';

/** アプリケーションを開始する */
function startApplication(): void {
  initApp();

  // サーバー起動
  const app = new Server();
}

startApplication();
