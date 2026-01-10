<template>
    <div class="w-72 space-y-1">
        <!-- プログレスバー -->
        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
            <div
                class="h-full bg-green-500 transition-all duration-300"
                :style="{ width: clamped + '%' }"
            />
        </div>

        <!-- 数値表示 -->
        <p class="text-gray-700 font-medium">{{ clamped }}%</p>
    </div>
</template>

<script setup lang="ts">
/** プログレスバーコンポーネント */

import { computed } from "vue";
import { clamp } from "@/services/data/number";

const props = defineProps<{
    progress: number;
}>();

const clamped = computed(() => clamp(Math.floor(props.progress), 0, 100));
</script>
