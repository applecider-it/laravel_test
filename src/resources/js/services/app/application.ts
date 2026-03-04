import { getMetaJson } from "@/services/data/html";

import { User } from "./types";

/**
 * ログインユーザーを返す。 
 */
export function getAuthUser(): User | null {
  return getMetaJson('user');
}