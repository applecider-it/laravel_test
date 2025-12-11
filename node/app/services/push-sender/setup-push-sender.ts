/**
 * プッシュ通知のセットアップ
 */

import { loadEnv } from '@/services/system/env.js';

import PushSender from './PushSender.js';

loadEnv();

async function main(): Promise<void> {
  console.log(
    'process.env.APP_VAPID_PUBLIC_KEY',
    process.env.APP_VAPID_PUBLIC_KEY
  );

  const mailto = 'mailto:you@example.com';
  const publicKey = process.env.APP_VAPID_PUBLIC_KEY as string;
  const privateKey = process.env.APP_VAPID_PRIVATE_KEY as string;

  const pushSender = new PushSender(mailto, publicKey, privateKey);

  await pushSender.execPushSender();
}

main().then(() => process.exit());
