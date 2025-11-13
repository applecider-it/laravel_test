import { loadEnv } from '@/services/system/env.ts';
import Server from '@/services/web-socket/Server.ts';

import { log } from '@/services/system/log.ts';

/** アプリケーションを開始する */
export function startApplication(): void {
    loadEnv();

    log('process.env.LARAVEL_API_URL', process.env.LARAVEL_API_URL);
    log(`process.env.WS_JWT_SECRET: ${process.env.WS_JWT_SECRET}`);

    // サーバー起動
    const app = new Server({
        host: '0.0.0.0',
        port: 8080,
    });
}
//# sourceMappingURL=application.js.map