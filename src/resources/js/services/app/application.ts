import { User } from "./types";

/**
 * ログインユーザーを返す。 
 */
export function getAuthUser(): User {
  const meta = document.querySelector('meta[name="user"]') as HTMLElement;

  if (meta) {
      const json = meta.dataset.json;
      const arr = JSON.parse(json);

      return arr;
  }

  return null;
}