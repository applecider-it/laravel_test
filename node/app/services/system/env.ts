import dotenv from 'dotenv';
import { dirname } from 'path';
import { fileURLToPath } from 'url';

import { log } from '@/services/system/log.ts';

/** .env読み込み */
export function loadEnv(): void {
  log('import.meta.url', import.meta.url);
  const dir = dirname(dirname(dirname(dirname(fileURLToPath(import.meta.url)))));
  dotenv.config({ path: `${dir}/.env` });
}
