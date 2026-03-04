/**
 * HTML関連
 */

/** HTMLエスケープ */
export function escapeHtml(str) {
    str = String(str);
    return str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

/**
 * (vueの補助機能)
 * 別コンポーネントで v-model を使えるようにする
 */
export function vuePropModel<T = any>(key: string) {
    return {
        get(this: any): T {
            return this[key];
        },
        set(this: any, value: T) {
            this.$emit(`update:${key}`, value);
        },
    };
}

/**
 * METAタグ内のJSONデータを返す。
 */
export function getMetaJson(name: string) {
    const meta = document.querySelector(`meta[name="${name}"]`) as HTMLElement;

    if (meta) {
        const json = meta.dataset.json;
        const arr = JSON.parse(json);

        return arr;
    }

    return null;
}
