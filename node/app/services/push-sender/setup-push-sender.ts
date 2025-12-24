/**
 * プッシュ通知のセットアップ
 */

import { initApp } from '@/services/system/init.js';

import PushSender from './PushSender.js';

import { appConfig } from '@/config/config.js';

initApp();

async function main(): Promise<void> {
  const mailto = `mailto:${appConfig.push.mailto}`;
  const publicKey = appConfig.push.publicKey;
  const privateKey = appConfig.push.privateKey;

  const pushSender = new PushSender(mailto, publicKey, privateKey);

  await pushSender.execPushSender();
}

main().then(() => process.exit());
