import { getMetaJson } from "@/services/data/html";

import { AdminUser } from "./types";

/**
 * ログイン中の管理者を返す。 
 */
export function getAuthAdminUser(): AdminUser | null {
  return getMetaJson('admin-user');
}