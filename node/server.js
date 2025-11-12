import dotenv from 'dotenv';
import { dirname } from 'path';
import { fileURLToPath } from 'url';

import WebSocketServerApp from './services/WebSocketServerApp.js';

// .env読み込み
const __dirname = dirname(fileURLToPath(import.meta.url));
dotenv.config({ path: `${__dirname}/.env` });

// サーバー起動
const app = new WebSocketServerApp({
  host: '0.0.0.0',
  port: 8080,
});
