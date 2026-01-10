<script setup lang="ts">
defineProps<{
    isLoading: boolean;
}>();
</script>

<template>
    <div
        class="fixed inset-0 flex justify-center items-center z-50 select-none bg-black bg-opacity-10 transition-opacity duration-500 ease-in-out"
        :class="
            isLoading
                ? 'opacity-100 pointer-events-auto'
                : 'opacity-0 pointer-events-none'
        "
    >
        <div
            class="w-10 h-10 border-2 border-gray-500 border-t-transparent rounded-full animate-spin shadow-md"
            :style="{ animationDuration: '1.2s' }"
        />
    </div>
</template>
