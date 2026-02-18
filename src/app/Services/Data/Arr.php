<?php

namespace App\Services\Data;

/**
 * 配列関連
 */
class Arr
{
    /**
     * 特定のキーを再帰的に隠す
     */
    public static function mask(array $array, array $keys, string $maskValue = '[Filtered]'): array
    {
        array_walk_recursive($array, function (&$value, $key) use ($keys, $maskValue) {
            if (in_array($key, $keys, true)) $value = $maskValue;
        });

        return $array;
    }
}
