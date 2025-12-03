/**
 * 数値関連
 */

/** min〜maxの範囲に成型（クランプ） */
export function clamp(value: number, min: number, max: number): number {
    return Math.min(Math.max(value, min), max);
}
