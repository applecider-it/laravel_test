
import { getFullTimeStr } from '#services/data/date.js';

/** ログを出力 */
export function log(...params) {
  const now = new Date();
  const formatted = getFullTimeStr(now);

  console.log(`${formatted}: `, ...params);
}
